<?php

class Sam_Import_LayoutValidate
{

	private $_return = array() ;


	public function init()
    {
    	
    }
    

    public function indexAction()
    {
    
    }
    
    
    public function validate($data, $validates, $field)
    {
    	$res = array(); // $this->_return
				if (isset($validates)){
					foreach($validates as $chave){
						$res[$field][$chave] =  $this->$chave($data);
					}
				}
				return $res;
    }


}