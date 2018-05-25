<?php

class Sam_Import_XmlImportCardioDB
{
	
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

	
	public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		
    
    }
    
    public function createXml(){

    	$this->_xml = new SimpleXMLElement('<MovimentacaoCadastralAtualizacaoCompleta></MovimentacaoCadastralAtualizacaoCompleta>');
		$this->_xml->addAttribute('xmlns', 'MovimentacaoCadastralAtualizacaoCompleta.xsd');
		foreach ($this->_data as $key=>$data){
    		$this->setAtualizacaoCompleta($data, $key);
    }

		return $this->_xml;
    	die();
    	
    }
    
    private function setAtualizacaoCompleta($data,$key){
    	$this->_xml->addChild('AtualizacaoCompleta',"");
    	$this->_xml->AtualizacaoCompleta[$key]->Contrato = @$data['Contrato'];
    	$this->_xml->AtualizacaoCompleta[$key]->RDP = @$data['RDP'];
    	$this->_xml->AtualizacaoCompleta[$key]->Familia = @$data['Familia'];
    	$this->_xml->AtualizacaoCompleta[$key]->Matricula = @$data['Matricula'];
    	$this->_xml->AtualizacaoCompleta[$key]->IncluidoComoRN = @$data['IncluidoComoRN'];
    	$this->_xml->AtualizacaoCompleta[$key]->GrauDependencia = @$data['GrauDependencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->InicioVigencia = @$data['InicioVigencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->FimVigencia = @$data['FimVigencia'];
    	$this->setPessoa($data['Pessoa'],$key);
    	$this->setModulos($data['Modulos'],$key);
    	$this->setLotacao($data['Lotacao'],$key);
    	 
    	
    }
    
    private function setPessoa($data,$key){
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Nome = @$data['Nome'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->DataNascimento = @$data['DataNascimento'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Cnp = @$data['Cnp'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Tipo = @$data['Tipo'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Sexo = @$data['Sexo'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->EstadoCivil = @$data['EstadoCivil'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Naturalidade = @$data['Naturalidade'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->NomePai = @$data['NomePai'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->NomeMae = @$data['NomeMae'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->NomeConjuge = @$data['NomeConjuge'];
		$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Invalidez = @$data['Invalidez'];
		$this->setEmal(@$data['Emails'],$key) ;
		$this->setRegistro(@$data['Registro'],$key);
		$this->setEndereco(@$data['Endereco'],$key);
		$this->setTelefone(@$data['Telefone'],$key);
		
    }
    
    private function setEmal($data,$key){
    	
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Emails->Email = @$data['Email'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Emails->Seq = 1;
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Emails->InicioVigencia = @$data['InicioVigencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Emails->FimVigencia = @$data['FimVigencia'];

    }
    
    private function setRegistro($data,$key){
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->addChild('Registro',"");
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[0]->tipo = @$data['RG']['Tipo'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[0]->Numero = @$data['RG']['Numero'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[0]->OrgaoExp = @$data['RG']['OrgaoExp'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[0]->UFExp = @$data['RG']['UFExp'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[0]->DataExp = @$data['RG']['DataExp'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->addChild('Registro',"");
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[1]->tipo = @$data['PIS']['Tipo'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[1]->Numero = @$data['PIS']['Numero'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->addChild('Registro',"");
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[2]->tipo = @$data['CNS']['Tipo'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Registro[2]->Numero = @$data['CNS']['Numero'];
   
    }
    
    private function setEndereco($data,$key){
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->Seq = @$data['Seq'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->NumLogradouro = @$data['NumLogradouro'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->NomeLogradouro = @$data['NomeLogradouro'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->ComplLogradouro = @$data['ComplLogradouro'];
      	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->Bairro = @$data['Bairro'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->Cidade = @$data['Cidade'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->Cep = @$data['Cep'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->PontoReferencia = @$data['PontoReferencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->CaixaPostal = @$data['CaixaPostal'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->Tipo = @$data['Tipo'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->ParaCorrespondencia = @$data['ParaCorrespondencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->ParaCobranca = @$data['ParaCobranca'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->ParaFaturamento = @$data['ParaFaturamento'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->ParaPublicacao = @$data['ParaPublicacao'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->InicioVigencia = @$data['InicioVigencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Endereco->FimVigencia = @$data['FimVigencia'];

    }
    
    private function setTelefone($data,$key){
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Telefone->Seq = @$data['Seq'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Telefone->Tipo = @$data['Tipo'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Telefone->DDD = @$data['DDD'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Telefone->Numero = @$data['Numero'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Telefone->InicioVigencia = @$data['InicioVigencia'];
    	$this->_xml->AtualizacaoCompleta[$key]->Pessoa->Telefone->FimVigencia = @$data['FimVigencia'];
    
    }
    
    private function setModulos($data,$key){
    	 
		$this->_xml->AtualizacaoCompleta[$key]->Modulos->Codigo = @$data['Codigo'];
		$this->_xml->AtualizacaoCompleta[$key]->Modulos->DataBaseCob = @$data['DataBaseCob'];
		$this->_xml->AtualizacaoCompleta[$key]->Modulos->InicioVigencia = @$data['InicioVigencia'];
		$this->_xml->AtualizacaoCompleta[$key]->Modulos->QteMensRetr = @$data['QteMensRetr'];
		$this->_xml->AtualizacaoCompleta[$key]->Modulos->Participativo = @$data['Participativo'];
		
    }
    
    private function setLotacao($data,$key){
    
		$this->_xml->AtualizacaoCompleta[$key]->Lotacao->Codigo = @$data['Codigo'];
		$this->_xml->AtualizacaoCompleta[$key]->Lotacao->InicioVigencia = @$data['InicioVigencia'];

    	}
    
	public function setDados($dados){
		$matricula = 0;
		$rdp = 0;
		$cont_dep_filho = 10;
		$cont_dep_filha = 30;
		$cont_dep_irmao = 60;
		foreach ($dados[3] as $value){
			switch($value['tp_movimento']){
				case 1: $tpmov = 1; break;
				case 2: $tpmov = 1; break;
				case 3: $tpmov = 2; break;
				default: $tpmov = 3; break;
			}
		if ($matricula == @$value['mat_empresa'] && @$value['parentesco'] != 0){
			switch (@$value['parentesco']){
				case 1: $rdp = 0; break;
				case 2: $rdp = 1; break;
				case 3: $rdp = 2; break;
				case 4: $rdp = $cont_dep_filho+1; break;
				case 5: $rdp = $cont_dep_filha+1; break;
				case 6: if (@$value['sexo_beneficiario'] == 'M') $rdp = 50;
						else $rdp = 51; break;
				case 8: if (@$value['sexo_beneficiario'] == 'M') $rdp = 52;
						else $rdp = 53; break;
				case 9: $rdp = $cont_dep_irmao+1; break;
				default: $rdp = 0; break;
			}
		}
		$matricula = @$value['mat_empresa'];
		$data[] = array(
				'Contrato' => @$dados[1][0]['cod_contrato'],
				'RDP' => $rdp,
				'Familia' => '1',
				'Matricula' => @$value['mat_empresa'],
				'IncluidoComoRN' => 'N',
				'GrauDependencia' => @$value['parentesco'],
				'InicioVigencia' => @$value['data_inclusao'],
				'FimVigencia' => @$value['data_exclusao'],
				'Pessoa' => array(
						'Nome' => @$value['nome_completo'],
						'DataNascimento' => '22/10/1986',
						'Cnp' => '12345',
						'x' => $tpmov,
						'Sexo' => @$value['sexo_beneficiario'],
						'EstadoCivil'  => @$value['estado_civil'],
						'Naturalidade'  => '1',
						'NomePai' => '',
						'NomeMae' => @$value['nome_mae'],
						'NomeConjuge' => '',
						'Invalidez' => 'nao',
						'Emails' => array(
								'Email'	=> @$value['email_titular'],
								'InicioVigencia' => @$value['data_inclusao'],
								'FimVigencia' => @$value['data_exclusao'],
						),
						'Registro' => array(
								'RG'=>array(
										'Tipo' => 1,
										'Numero' => @$value['rg'],
										'OrgaoExp' =>  @$value['orgao_emissor_rg'],
										'UFExp' =>  @$value['cod_uf_emissor_rg'],
										'DataExp' =>  @$value['dt_emissao_rg'],
								),
								'PIS'=>array(
										'Tipo' => 2,
										'Numero' => @$value['pis'],
								),
								'CNS'=>array(
										'Tipo' => 3,
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
								'PontoReferencia'=>'',
								'CaixaPostal'=>'',
								'Tipo'=>'',
								'ParaCorrespondencia'=>'S',
								'ParaCobranca'=>'S',
								'ParaFaturamento'=>'S',
								'ParaPublicacao'=>'S',
								'InicioVigencia' => @$value['data_inclusao'],
								'FimVigencia' => @$value['data_exclusao'],
						),
						'Telefone'=> array(
								'Seq'=>'1',
								'Tipo'=>'Cel',
								'DDD'=> 12,
								'Numero'=>91122222,
								'InicioVigencia' => @$value['data_inclusao'],
								'FimVigencia' => @$value['data_exclusao'],
						),
				),
				'Modulos' => array(
						'Codigo'=>1,
						'DataBaseCob'=>2,
						'InicioVigencia'=>@$value['data_inclusao'],
						'QteMensRetr'=>2,
						'Participativo'=>'S',
				),
				'Lotacao'=> array(
						'Codigo'=>1,
						'InicioVigencia' => @$value['data_inclusao'],
				),
		);
		}
		$this->setData($data);
		
	}
}

