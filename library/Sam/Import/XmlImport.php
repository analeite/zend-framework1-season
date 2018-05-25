<?php

class Sam_Import_XmlImport {

    private $_data = array();
    private $_xml = array();

    public function getXml() {
        return $this->_xml;
    }

    public function setXml($_xml) {
        $this->_xml = $_xml;
    }

    public function getData() {
        return $this->_data;
    }

    public function setData($_data) {
        $this->_data = $_data;
    }

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        
    }

    public function createXml() {

        $this->_xml = new SimpleXMLElement("<?xml version='1.0' standalone='yes'?><MovimentacoesCadastrais></MovimentacoesCadastrais>");
        $xml_lote = $this->_xml->addChild('Lote');
        $xml_lote->addChild("codigo", date("Ymd"));
        //$this->_xml->addAttribute('xmlns', 'MovimentacaoCadastralAtualizacaoCompleta.xsd');
        foreach ($this->_data as $key => $data) {
            $this->setAtualizacaoCompleta($data, $xml_lote);
        }

        return $this->_xml;
        die();
    }
    private function dataXml($data) {
    	if ($data == "")
    		return null;
    	else {
    		$date = DateTime::createFromFormat('dmY', $data);
    		return $date->format('d/m/Y 00:00:00');
    	}
    }
    private function setAtualizacaoCompleta($data, $node) {
        if (@$data['Movimento'] == 3) {
            $movimentacao = $node->addChild('Exclusao');
            $movimentacao->addAttribute('lote',date("Ymd"));
            $movimentacao->addChild("Codigo", @$data['cod_carteira']);

            $movimentacao->addChild("DataExclusao", @$data['FimVigencia']);
            if (trim(@$data['motivoexclusao']) != '')
                $movimentacao->addChild("MotivoExclusao", @$data['motivoexclusao']);
            $movimentacao->addChild("Contrato", @$data['Contrato']);
            $movimentacao->addChild("Importado", true);
            $movimentacao->addChild("Familia", @$data['Familia']);
            $movimentacao->addChild("RDP", @$data['RDP']);
            $movimentacao->addChild("GrauDependencia", @$data['GrauDependencia']);
        } else {
            if (@$data['Movimento'] == 1) {
                $movimentacao = $node->addChild('Inclusao');
            } elseif (@$data['Movimento'] == 2) {
                $movimentacao = $node->addChild('Alteracao');
            }
            $movimentacao->addAttribute('lote',date("Ymd"));
            $xml_benef = $movimentacao->addChild("Beneficiario");
            $xml_benef->addChild("Codigo", @$data['cod_carteira']);
            $xml_benef->addChild("Familia", @$data['Familia']);
            $xml_benef->addChild("InicioVigencia", @$data['InicioVigencia']);
            $xml_benef->addChild("Tipo", null);
            if (@$data['RDP'] > 0) {
                $xml_benef->addChild("Titular", @$data['cod_titular']);
            }

            $xml_benef->addChild("RDP", @$data['RDP']);
            $xml_benef->addChild("GrauDependencia", @$data['GrauDependencia']);
            $xml_benef->addChild("Contrato", @$data['Contrato']);
            
            $this->setPessoa($data['Pessoa'], $xml_benef);
            if (@$data['Movimento'] == 1) {
                if ( isset($data['Modulos']) )
                    $this->setModulos($data['Modulos'], $xml_benef);
                if ( isset($data['Lotacao']) )
                    $this->setLotacao($data['Lotacao'], $xml_benef);
            }
            $xml_benef->addChild("Matricula",@$data['Matricula']);
        }
    }

    private function setPessoa($data, $node) {
        $pessoa = $node->addChild('Pessoa');
        $pessoa->addAttribute("Contrato",@$data['Contrato']);
        $pessoa->Nome = @$data['Nome'];
        $pessoa->NomeReduzido = @$data['Nome'];
        $pessoa->DataNascimento = @$data['DataNascimento'];
        $pessoa->Sexo = @$data['Sexo'];
        if(@$data['Cnp'] <> '00000000000')
        $pessoa->Cnp = @$data['Cnp'];
        else
        $pessoa->Cnp= '';
        $pessoa->EstadoCivil = @$data['EstadoCivil'];
        $pessoa->NomeMae = @$data['NomeMae'];
        $pessoa->Tipo = @$data['Tipo'];
        
        
        //$node->Pessoa->Naturalidade = @$data['Naturalidade'];
        //$node->Pessoa->NomePai = @$data['NomePai'];
        //$node->Pessoa->NomeConjuge = @$data['NomeConjuge'];
        //$node->Pessoa->Invalidez = @$data['Invalidez'];
        
        $this->setEndereco(@$data['Endereco'], $pessoa);
        $this->setTelefone(@$data['Telefone'], $pessoa);
        $this->setRegistro(@$data['Registro'], $pessoa);
        $this->setEmal(@$data['Emails'], $pessoa);
        
        
    }

    private function setEmal($data, $node) {
        if ( trim(@$data['Email']) != '') {
            $node->PessoaEmail->Email = @$data['Email'];
            $node->PessoaEmail->InicioVigencia = @$data['InicioVigencia'];
        }
    }

    private function setRegistro($data, $node) {
        if ( trim(@$data['RG']['Numero']) != '' ) {
            $rg = $node->addChild('Registro');
            $rg->tipo = @$data['RG']['Tipo'];
            $rg->Numero = @$data['RG']['Numero'];
            if ( @$data['RG']['OrgaoExp'] != "")
                $rg->OrgaoExp = @$data['RG']['OrgaoExp'];
            if ( @$data['RG']['UFExp'] != "")
                $rg->UFExp = @$data['RG']['UFExp'];
            if ( @$data['RG']['DataExp'] != "")
                $rg->DataExp = @$data['RG']['DataExp'];
            else 
                $rg->DataExp = "";
        }
        if ( @$data['PIS']['Numero'] > 0 && @$data['PIS']['Numero'] <> '00000000000000000' ) {
            $pis = $node->addChild('Registro');
            $pis->tipo = @$data['PIS']['Tipo'];
            $pis->Numero = @$data['PIS']['Numero'];
        }
        if ( @$data['CNS']['Numero'] > 0 ) {
            $cns = $node->addChild('Registro');
            $cns->tipo = @$data['CNS']['Tipo'];
            $cns->Numero = @$data['CNS']['Numero'];
        }
    }

    private function setEndereco($data, $node) {
        //$node->Endereco->Seq = @$data['Seq'];
        $node->Endereco->NomeLogradouro = @$data['NomeLogradouro'];
        $node->Endereco->ComplLogradouro = @$data['ComplLogradouro'];
        $node->Endereco->Bairro = @$data['Bairro'];
        $node->Endereco->Cidade = @$data['Cidade'];
        $node->Endereco->Cep = @$data['Cep'];
        $node->Endereco->NumLogradouro = @$data['NumLogradouro'];
        $node->Endereco->UF = @$data['UF'];
        //$node->Endereco->PontoReferencia = @$data['PontoReferencia'];
        //$node->Endereco->CaixaPostal = @$data['CaixaPostal'];
        $node->Endereco->Tipo = @$data['Tipo'];
        $node->Endereco->ParaCorrespondencia = @$data['ParaCorrespondencia'];
        $node->Endereco->ParaFaturamento     = @$data['ParaFaturamento'];
        $node->Endereco->ParaCobranca        = @$data['ParaCobranca'];
        $node->Endereco->InicioVigencia      = @$data['InicioVigencia'];
    }

    private function setTelefone($data, $node) {
        //$node->Telefone->Seq = @$data['Seq'];
        if ( trim(@$data['TELEFONE']['Numero']) != ''){
            $tel =  $node->addChild('Telefone');
            $tel->Tipo = @$data['TELEFONE']['Tipo'];
            $tel->DDD = @$data['TELEFONE']['DDD'];
            $tel->Numero = @$data['TELEFONE']['Numero'];
            $tel->InicioVigencia = @$data['TELEFONE']['InicioVigencia'];
        }
        if ( trim(@$data['CELULAR']['Numero']) != ''){
            $tel =  $node->addChild('Telefone');
        
            $tel->Tipo = @$data['CELULAR']['Tipo'];
            $tel->DDD = @$data['CELULAR']['DDD'];
            $tel->Numero = @$data['CELULAR']['Numero'];
            $tel->InicioVigencia = @$data['CELULAR']['InicioVigencia'];
        }
        //$node->Telefone->FimVigencia = @$data['FimVigencia'];
    }

    private function setModulos($data, $node) {

        $node->Modulo->Codigo = @$data['Codigo'];
        $node->Modulo->InicioVigencia = @$data['InicioVigencia'];
        $node->Modulo->QteMensRetr = @$data['QteMensRetr'];
        $node->Modulo->DataBaseCob = @$data['DataBaseCob'];
        //$node->Modulo->Participativo = @$data['Participativo'];
    }

    private function setLotacao($data, $node) {

        if ( !empty($data['Codigo'])){
            $node->LotacaoBeneficiario->Codigo = @$data['Codigo'];
            $node->LotacaoBeneficiario->InicioVigenciaLot = @$data['InicioVigencia'];
        }
    }

    public function codcarteira($contrato, $familia, $dep) {
        if (strlen(trim($contrato)) == 8)
            $cod = "1" . substr($contrato, 1, 5) . substr('00000' . $familia, strlen('00000' . $familia) - 5, 5) . substr('00' . $dep, strlen('00' . $dep) - 2, 2);
        else
            $cod = "1" . substr($contrato, 1, 4) . substr('000000' . $familia, strlen('000000' . $familia) - 6, 6) . substr('00' . $dep, strlen('00' . $dep) - 2, 2);
        return "00" . $cod . $this->mod11($cod, 1, 9);
    }

    private function Mod11($NumDado, $NumDig, $LimMult) {

        $Dado = $NumDado;
        for ($n = 1; $n <= $NumDig; $n++) {
            $Soma = 0;
            $Mult = 2;
            for ($i = strlen($Dado) - 1; $i >= 0; $i--) {
                $Soma += $Mult * intval(substr($Dado, $i, 1));
                if (++$Mult > $LimMult)
                    $Mult = 2;
            }
            $Dado .= strval(fmod(fmod(($Soma * 10), 11), 10));
        }
        return substr($Dado, strlen($Dado) - $NumDig);
    }
    private function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    private function retiraZeroPIS($str) {
        return substr($str, -11);
    }
    private function retiraZeroMatricula($str){
        if(strlen($str) > 9 )
        return substr($str, -10);
        else
            return $str; 
    }
    private function orgao_emissor($cod){
        switch ( trim(strtoupper($cod)) ){
            case "SSP": return 34;
            default: return "";    
        }
    }
    private function estado_civil($cod){
        switch ( intval($cod) ){
            case 1: return "S";
            case 2: return "M";
            case 3: return "W";
            case 4: return "D";
            case 5: return "D";
            case 9: return "U";
            default: return "";    
        }
    }
    private function motivo_exclusao($cod){
        switch ( intval($cod) ){
            case 4: return 5;
            default: return 3;    
        }
    }
    public function setDados($contrato, $dados) {
        
        $unicontrato = new Application_Model_DbTable_Unicontrato();
        $objcontrato = $unicontrato->find($contrato)->current();
        
        $matricula = 0;
        $rdp = 0;
        $cont_dep_filho = 10;
        $cont_dep_filha = 30;
        $cont_dep_irmao = 60;
        $cache_familia = array();
        $cache_rdp = array();
        $model_benef = new Application_Model_DbTable_Beneficiario();
        $proximaFamilia = $model_benef->novaFamilia($contrato);
        foreach ($dados['3'] as $value) {
            $tpmov = 0;
            switch (@$value['tp_movimento']) {
                case 1:
                case 2: $tpmov = 1;
                    break;
                case 3: $tpmov = 2;
                    break;
                case 4:
                case 5: $tpmov = 3;
                    break;
            }
            /*
            if ($matricula == @$value['mat_empresa'] && @$value['parentesco'] != 0) {
                switch (@$value['parentesco']) {
                    case 1: $rdp = 0;
                        break;
                    case 2: $rdp = 1;
                        break;
                    case 3: $rdp = 2;
                        break;
                    case 4: $rdp = $cont_dep_filho + 1;
                        break;
                    case 5: $rdp = $cont_dep_filha + 1;
                        break;
                    case 6: if (@$value['sexo_beneficiario'] == 'M')
                            $rdp = 50;
                        else
                            $rdp = 51; break;
                    case 8: if (@$value['sexo_beneficiario'] == 'M')
                            $rdp = 52;
                        else
                            $rdp = 53; break;
                    case 9: $rdp = $cont_dep_irmao + 1;
                        break;
                    default: $rdp = 0;
                        break;
                }
            }
             * 
             */
            $graudeparentesco = null;
            if ( $value['parentesco'] == 0 ) $value['parentesco'] = 1;
            switch (@$value['parentesco']) {
                case 1: $graudeparentesco = 0;
                    break;
                case 2: $graudeparentesco = @$value['sexo_beneficiario'] == 'M' ? 9 : 2;
                    break;
                case 3: $graudeparentesco = 2;
                    break;
                case 4: $graudeparentesco = 10;
                    break;
                case 5: $graudeparentesco = 30;
                    break;
                case 6: $graudeparentesco = @$value['sexo_beneficiario'] == 'M' ? 50 : 51;
                    break;
                case 8: $graudeparentesco = @$value['sexo_beneficiario'] == 'M' ? 52 : 53;
                    break;
                case 9: $graudeparentesco = 80;
                    break;
                case 10: $graudeparentesco = @$value['sexo_beneficiario'] == 'M' ? 70 : 75;
                    break;
                case 11: $graudeparentesco = 90;
                    break;
            }


            if ($tpmov == 2 || $tpmov == 3) {
                $carteira = ltrim (@$value['parentesco'] == 1 ? @$value['cod_titular'] : @$value['cod_dependente'],'0');
                if (strlen(trim($objcontrato['Codigo'])) == 8) {
                    $familia = substr($carteira, 6, 5);
                    $rdp = $graudeparentesco == 0 ? 0 : substr($carteira, 11, 2);
                } else {
                    $familia = substr($carteira, 5, 6);
                    $rdp = $graudeparentesco == 0 ? 0 : substr($carteira, 11, 2);
                }
            } elseif ($tpmov == 1) {
                if ($graudeparentesco == 0) { // TITULAR
                    $familia = $proximaFamilia;
                    $rdp = 0;
                    $cache_familia[@$value['mat_empresa']] = $familia;
                    $proximaFamilia++;
                } else { // DEPENDENTE
                    if (@$value['cod_titular'] == 0) {
                        if (!isset($cache_familia[@$value['mat_empresa']]))
                            die('Dependente sem titular. Matricula: ' . @$value['mat_empresa']);

                        $familia = $cache_familia[@$value['mat_empresa']];
                    } else {
                        if (strlen(trim($objcontrato['Codigo'])) == 8) {
                            $familia = substr(@ltrim($value['cod_titular'],'0'), 6, 5);
                        } else {
                            $familia = substr(@ltrim($value['cod_titular'],'0'), 5, 6);
                        }
                    }
                    if (isset($cache_rdp[$familia][$graudeparentesco])) {
                        $cache_rdp[$familia][$graudeparentesco]++;
                    } else {
                        $cache_rdp[$familia][$graudeparentesco] = $model_benef->verificaRdp($contrato, $familia, $graudeparentesco);
                    }
                    $rdp = $cache_rdp[$familia][$graudeparentesco];
                }
            }
            $carteira = $this->codcarteira($objcontrato['Codigo'], $familia, $rdp);
            $carteira_titular = $this->codcarteira($objcontrato['Codigo'], $familia, 0);
            
//            print_r(
//                    array(
//                        'cod_titular' => ltrim($value['cod_titular'],'0'),
//                        'graudeparentesco' => $graudeparentesco,
//                        'Contrato' => $objcontrato['Codigo'],
//                        'Familia'  => $familia,
//                        'Rdp'  => $rdp,
//                        'Carteira Titular' => $carteira_titular,
//                        'Carteira' => $carteira,
//                    )
//                    );
//            die('FIM DEBUG'); 
            $matricula = @$value['mat_empresa'];
            
            if ( $contrato == '294846'){
                if ( $value['term_contrato'] == 17  )
                    $value['modulooperadora'] = '001097117' ; // B = Enfermaria
                if ( $value['term_contrato'] == 37  )
                    $value['modulooperadora'] = '001097137' ; // A = Apartamento
                if ( $value['term_contrato'] == 47  )
                    $value['modulooperadora'] = '001097147' ; // internacao enfermaria nacional copart
                if ( $value['term_contrato'] == 57  )
                    $value['modulooperadora'] = '001097157' ; // internacao apartamento nacional
            }
                    
            $telefone = $this->soNumero($value['telefone']);
            $ddd_telefone = substr($telefone,0,2);
            $telefone = substr($telefone,2,9);
            $celular = $this->soNumero($value['celular']);
            $ddd_celular = substr($celular,0,2);
            $celular = substr($celular,2,9);
            $data[] = array(
                'Contrato' => $objcontrato['Codigo'],
                'RDP' => $rdp,
                'Familia' => $familia,
                'Matricula' => $this->retiraZeroMatricula(@$value['mat_empresa']),
                'Movimento' => $tpmov,
                'IncluidoComoRN' => 'N',
                'GrauDependencia' => $graudeparentesco,
                'cod_titular' => $carteira_titular,
                'cod_carteira' => $carteira,
                'InicioVigencia' => $this->dataXml(@$value['inicio_vigencia']),
                'FimVigencia' => $this->dataXml(@$value['fim_vigencia']),
                'motivoexclusao' => $this->motivo_exclusao(@$value['motivo_cancelamento']), // TODO: motivo_cancelamento
                'Pessoa' => array(
                    'Nome' => @$value['nome_completo'],
                    'Contrato' => $objcontrato['Codigo'],
                    'DataNascimento' => $this->dataXml(@$value['dt_nascimento']),
                    'Cnp' => @$value['cpf'],
                    'Sexo' => @$value['sexo_beneficiario'],
                    'EstadoCivil' => $this->estado_civil(@$value['estado_civil']),
                    'Naturalidade' => '1',
                    'NomePai' => '',
                    'NomeMae' => @$value['nome_mae'],
                    'NomeConjuge' => '',
                    'Invalidez' => 'nao',
                    'Tipo' => 2,
                    'Emails' => array(
                        'Email' => @$value['email_titular'],
                        'InicioVigencia' => date('d/m/Y').' 00:00:00',
                        //'FimVigencia' => @$value['data_exclusao'],
                    ),
                    'Registro' => array(
                        'RG' => array(
                            'Tipo' => 1,
                            'Numero' => @$value['rg'],
                            'OrgaoExp' => $this->orgao_emissor(@$value['orgao_emissor_rg']),
                            'UFExp' => @$value['cod_uf_emissor_rg'],
                            'DataExp' => $this->dataXml(@$value['dt_emissao_rg']),
                        ),
                        'PIS' => array(
                            'Tipo' => 9,
                            'Numero' => $this->retiraZeroPIS(@$value['pis']),
                        ),
                        'CNS' => array(
                            'Tipo' => 10,
                            'Numero' => @$value['sus'],
                        ),
                    ),
                    'Endereco' => array(
                        'Seq' => 1,
                        'NumLogradouro' => @$value['numero_endereco'],
                        'NomeLogradouro' => @$value['logradouro'],
                        'ComplLogradouro' => @$value['complemento_endereco'],
                        'Bairro' => @$value['bairro'],
                        'Cidade' => @$value['cidade'],
                        'Cep' => @$value['cep'],
                        'UF' => @$value['uf'],
                        'PontoReferencia' => '',
                        'CaixaPostal' => '',
                        'Tipo' => '1',
                        'ParaCorrespondencia' => true,
                        'ParaCobranca' => true,
                        'ParaFaturamento' => true,
                        'ParaPublicacao' => true,
                        'InicioVigencia' => date('d/m/Y').' 00:00:00',
                        //'FimVigencia' => @$value['data_exclusao'],
                    ),
                    'Telefone' => array(
                        'CELULAR' => array(
                                'Tipo' => '2',
                                'DDD' => $ddd_celular,
                                'Numero' => $celular,
                                'InicioVigencia' => date('d/m/Y').' 00:00:00'
                        ),
                        'TELEFONE' => array(
                                'Tipo' => '1',
                                'DDD' => $ddd_telefone,
                                'Numero' => $telefone,
                                'InicioVigencia' => date('d/m/Y').' 00:00:00'
                        )
                    ),
                ),
                'Modulos' => array(
                    'Codigo' => trim(@$value['modulooperadora']), // APARTAMENTO ou Enfermaria
                    'DataBaseCob' => $this->dataXml(@$value['inicio_vigencia']),
                    'InicioVigencia' => $this->dataXml(@$value['inicio_vigencia']),
                    'QteMensRetr' => 0,
                    'Participativo' => 'S',
                ),
                
                'Lotacao' => array(
                    'Codigo' => $this->getCodigoLotacao($contrato,trim(@$value['codigolotacao'])),
                    'InicioVigencia' => $this->dataXml(@$value['inicio_vigencia']),
                ),
                 
            );
        }
        $this->setData($data);
    }
    private $cache_lotacao = array();
    public function getCodigoLotacao($contrato,$codigolotacao){
        if ( !isset($this->cache_lotacao[$contrato.':'.$codigolotacao]) ) {
            $tab = new Application_Model_DbTable_Unibeneficiario();
            $select = $tab->select();
            $select->setIntegrityCheck(false);
            $select->from(array('b' => 'LotacaoContrato'), array('AutoId','Codigo'))
                    ->where('Contrato = ?', $contrato)
                    ->where('Complemento = ?', $codigolotacao)
                   ;

            $row = $tab->fetchRow($select);
            if( $row != null ){
                $this->cache_lotacao[$contrato.':'.$codigolotacao] = $row->Codigo;
            } else {
                $this->cache_lotacao[$contrato.':'.$codigolotacao] = 0;
            }
        }
        //echo $contrato.':'.$codigolotacao." => ".$this->cache_lotacao[$contrato.':'.$codigolotacao];//die();
        
        return $this->cache_lotacao[$contrato.':'.$codigolotacao];
    }

}

