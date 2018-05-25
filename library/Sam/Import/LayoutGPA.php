<?php
require_once("Sam/Validate/Cpf.php");
class Sam_Import_LayoutGPA extends Sam_Import_LayoutImport
{

	public function init()
    {
    	parent::init();
    }
    

    public function indexAction()
    {
    	    	 
		parent::indexAction();
    
    }
    public function validateGeral() {
        parent::validateGeral();
        
        $cache_titular = array();
        $cache_dependente = array();
        
        $data = $this->getData();
        foreach ($data['3'] as $i=>$row ){
            if ( intval($row['parentesco']) == 0 || intval($row['parentesco']) == 1 ){
                unset($cache_dependente[$row['mat_empresa']]);
                $cache_titular[$row['mat_empresa']]=1;        
                continue;        
            }
            if ( $row['cod_titular'] != '00000000000000000'){
                continue;
            }
            if (isset($cache_titular[$row['mat_empresa']]))
                continue;
            $cache_dependente[$row['mat_empresa']]=1;
        }
        foreach ( $cache_dependente as $k=>$v){
            $this->_erro[] = 'Dependente sem titular - Matricula '.$k;
        }
    }
    //@overhide
    public  function setArrayConfig(){
    	$this->setValidate('Sam_Import_ValidateGPA');
    	$this->addConfig('header',null, 1, 'Alfa', 8);
    	 
    	$this->addConfig('1','sequencial', 8, 'int', 0,array('required'));
    	$this->addConfig('1','header', 1, 'int', 8,array('required'));
    	$this->addConfig('1','cod_contrato', 9, 'int', 9,array('required','contrato'));
    	$this->addConfig('1','data_geracao', 8, 'int', 25);
    	 
    	// tipo 3
    	$this->addConfig('3','sequencial', 8, 'int', 0,array('required'));
    	$this->addConfig('3','tipo_reg', 1, 'int', 8,array('required'));
    	$this->addConfig('3','tp_movimento', 2, 'int', 9,array('required'));
    	$this->addConfig('3','cod_empresa', 5, 'int', 11,array('required'));
    	$this->addConfig('3','mat_empresa', 20, 'Alfa', 16,array('required'));
    	$this->addConfig('3','identifica_dep', 4, 'int', 36);
    	$this->addConfig('3','cod_titular', 17, 'Alfa', 40);
    	$this->addConfig('3','cod_dependente', 17, 'Alfa', 57);
    	$this->addConfig('3','term_contrato', 8, 'int', 74);
    	$this->addConfig('3','un_atendimento', 4, 'int', 82);
    	$this->addConfig('3','filial', 4, 'int', 86,array('required'));//
    	$this->addConfig('3','departamento', 4, 'int', 90,null); //array('required')
    	$this->addConfig('3','sexo_beneficiario', 1, 'Alfa', 94,array('required','sexo'));
    	$this->addConfig('3','dt_nascimento', 8, 'string', 95,array('required','dtNascimento'));
    	$this->addConfig('3','estado_civil', 1, 'string', 103,array('required'));
        $this->addConfig('3','cpf', 11, 'string', 104,array('cpf'));
    	$this->addConfig('3','rg', 20, 'string', 115,array('rg'));
    	$this->addConfig('3','dt_emissao_rg', 8, 'date', 135);
    	$this->addConfig('3','orgao_emissor_rg', 5, 'Alfa', 143);
    	$this->addConfig('3','cod_uf_emissor_rg', 2, 'Alfa', 148,array('docRG'));
    	$this->addConfig('3','cod_pais_emissor_rg', 2, 'Alfa', 150);
    	$this->addConfig('3','cbo', 6, 'int', 152);
    	$this->addConfig('3','logradouro', 40, 'Alfa', 158,array('required'));
    	$this->addConfig('3','numero_endereco', 5, 'int', 198,array('required'));
    	$this->addConfig('3','complemento_endereco', 50, 'Alfa', 203);
    	$this->addConfig('3','bairro', 30, 'Alfa', 253,array('required'));
    	$this->addConfig('3','cep', 8, 'Alfa', 283,array('required'));
    	$this->addConfig('3','cidade', 50, 'Alfa', 291,array('required'));
    	$this->addConfig('3','uf', 2, 'Alfa', 341,array('required'));
    	$this->addConfig('3','parentesco', 2, 'int', 343,array('required','graudependencia'));
    	$this->addConfig('3','data_evento', 8, 'int', 345);
    	$this->addConfig('3','inicio_vigencia', 8, 'string', 353,array('required'));
    	$this->addConfig('3','fim_vigencia', 8, 'string', 361,null);
    	$this->addConfig('3','pis', 17, 'Alfa', 369, array('pis'));
    	$this->addConfig('3','sus', 17, 'Alfa', 386);
    	$this->addConfig('3','num_nascido_vivo', 11, 'Alfa', 403);
    	$this->addConfig('3','nome_completo', 70, 'Alfa', 414,array('required'));
    	$this->addConfig('3','nome_mae', 70, 'Alfa', 484,array('required'));
    	$this->addConfig('3','email_titular', 50, 'Alfa', 554);
    	$this->addConfig('3','telefone', 20, 'Alfa', 604,null);//array('required')
    	$this->addConfig('3','celular', 20, 'Alfa', 624);
    	$this->addConfig('3','motivo_inclusao', 1, 'Alfa', 644);
    	$this->addConfig('3','motivo_cancelamento', 3, 'int', 645);
    	$this->addConfig('3','data_falecimento', 8, 'string', 648);
    	$this->addConfig('3','modalidade', 2, 'int', 656);
    	$this->addConfig('3','padrao_cobertura', 8, 'int', 658);
    	$this->addConfig('3','contribuicao', 1, 'Alfa', 660, null);
    	$this->addConfig('3','periodo_contribuicao', 3, 'int',663, null);
    	$this->addConfig('3','adesao_ex_func', 1, 'Alfa', 664,null);
        $this->addConfig('3','codigolotacao', 15, 'Alfa', 665,array('required'));
        $this->addConfig('3','modulooperadora', 20, 'Alfa', 680,array('required'));
    	
    	
    	
    	$this->addConfig('9','sequencia', 8, 'int', 0);
    	$this->addConfig('9','tipo_reg', 1, 'int', 8);
    	$this->addConfig('9','qdt_registros', 8, 'int', 9);    
    }
    

}

