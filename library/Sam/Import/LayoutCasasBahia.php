<?php
require_once("Sam/Validate/Cpf.php");
class Sam_Import_LayoutCasasBahia extends Sam_Import_LayoutImport
{

	public function init()
    {
    	parent::init();
    }
    

    public function indexAction()
    {
    	    	 
		parent::indexAction();
    
    }
    //@overhide
    public  function setArrayConfig(){
    	$this->setValidate('Sam_Import_ValidateCasasBahia');
    	$this->addConfig('header',null, 1, 'Alfa', 8);
    	 
    	$this->addConfig('1','sequencial', 8, 'int', 0,array('required'));
    	$this->addConfig('1','header', 1, 'int', 8,array('required'));
    	$this->addConfig('1','cod_contrato', 9, 'int', 9,array('required','contrato'));
    	$this->addConfig('1','data_geracao', 8, 'int', 25);
    	 
    	// tipo 3
    	$this->addConfig('3','sequencial', 8, 'int', 0,array('required'));
    	$this->addConfig('3','tipo_reg', 1, 'int', 8,array('required'));
    	$this->addConfig('3','tp_movimento', 2, 'int', 9,array('required'));
    	$this->addConfig('3','cod_empresa', 4, 'int', 11,array('required'));
    	$this->addConfig('3','mat_empresa', 20, 'Alfa', 15,array('required'));
    	$this->addConfig('3','identifica_dep', 4, 'int', 35);
    	$this->addConfig('3','cod_titular', 17, 'Alfa', 39);
    	$this->addConfig('3','cod_dependente', 17, 'Alfa', 56);
    	$this->addConfig('3','term_contrato', 8, 'int', 73,array('required','termcontrato'));
    	$this->addConfig('3','un_atendimento', 4, 'int', 81);
    	$this->addConfig('3','filial', 4, 'int', 85,array('required'));
    	$this->addConfig('3','departamento', 4, 'int', 89,array('required'));
    	$this->addConfig('3','sexo_beneficiario', 1, 'Alfa', 93,array('required','sexo'));
    	$this->addConfig('3','dt_nascimento', 8, 'string', 94,array('required','dtNascimento'));
    	$this->addConfig('3','estado_civil', 1, 'string', 102,array('required'));
        $this->addConfig('3','cpf', 11, 'string', 103,array('cpf'));
    	$this->addConfig('3','rg', 20, 'string', 114,array('rg'));
    	$this->addConfig('3','dt_emissao_rg', 8, 'date', 134);
    	$this->addConfig('3','orgao_emissor_rg', 5, 'Alfa', 142);
    	$this->addConfig('3','cod_uf_emissor_rg', 2, 'Alfa', 147);//,array('docRG')
    	$this->addConfig('3','cod_pais_emissor_rg', 2, 'Alfa', 149);
    	$this->addConfig('3','cbo', 6, 'int', 151);
    	$this->addConfig('3','logradouro', 40, 'Alfa', 157,array('required'));
    	$this->addConfig('3','numero_endereco', 5, 'int', 197,array('required'));
    	$this->addConfig('3','complemento_endereco', 50, 'Alfa', 202);
    	$this->addConfig('3','bairro', 30, 'Alfa', 252,array('required'));
    	$this->addConfig('3','cep', 8, 'Alfa', 282,array('required'));
    	$this->addConfig('3','cidade', 50, 'Alfa', 290,array('required'));
    	$this->addConfig('3','uf', 2, 'Alfa', 340,array('required'));
    	$this->addConfig('3','parentesco', 2, 'int', 342,array('required','graudependencia'));
    	$this->addConfig('3','data_evento', 8, 'int', 344);
    	$this->addConfig('3','inicio_vigencia', 8, 'string', 352,array('required'));
    	$this->addConfig('3','fim_vigencia', 8, 'string', 360,array('required'));
    	$this->addConfig('3','pis', 17, 'Alfa', 368, array('pis'));
    	$this->addConfig('3','sus', 17, 'Alfa', 385);
    	$this->addConfig('3','num_nascido_vivo', 11, 'Alfa', 402);
    	$this->addConfig('3','nome_completo', 70, 'Alfa', 413,array('required'));
    	$this->addConfig('3','nome_mae', 70, 'Alfa', 483,array('required'));
    	$this->addConfig('3','email_titular', 50, 'Alfa', 553);
    	$this->addConfig('3','telefone', 20, 'Alfa', 603); // ,array('required')
    	$this->addConfig('3','celular', 20, 'Alfa', 623);
    	$this->addConfig('3','motivo_inclusao', 1, 'Alfa', 643);
    	$this->addConfig('3','motivo_cancelamento', 3, 'int', 644);
    	$this->addConfig('3','data_falecimento', 8, 'string', 647);
    	$this->addConfig('3','modalidade', 2, 'int', 655);
    	$this->addConfig('3','padrao_cobertura', 8, 'int', 657);
    	$this->addConfig('3','contribuicao', 1, 'Alfa', 659, null);
    	$this->addConfig('3','periodo_contribuicao', 3, 'int',662, null);
    	$this->addConfig('3','adesao_ex_func', 1, 'Alfa', 663,null);
    	$this->addConfig('3','filler', 36, 'Alfa', 664);
    	
    	
    	$this->addConfig('9','sequencia', 8, 'int', 0);
    	$this->addConfig('9','tipo_reg', 1, 'int', 8);
    	$this->addConfig('9','qdt_registros', 8, 'int', 9);    
    }
    

}

