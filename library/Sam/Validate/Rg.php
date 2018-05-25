<?php 
class Sam_Validate_Rg extends Zend_Validate_Abstract
{
	const RG_INVALIDO = "rg_invalido";
	
	protected $_messageTemplates = array (
		self::RG_INVALIDO => "Documento Inválido"
	);

	public function isValid($value)
	{
	    $len = strlen($value);
	    $vls = array( str_repeat('1', $len),
	                  str_repeat('2', $len),
	                  str_repeat('3', $len),
	                  str_repeat('4', $len),
	                  str_repeat('5', $len),
	                  str_repeat('6', $len),
	                  str_repeat('7', $len),
	                  str_repeat('8', $len),
	                  str_repeat('9', $len),
	                  str_repeat('0', $len));
	                  
		if ( in_array($value, $vls) ) {
			$this->_error(self::RG_INVALIDO);
			return false;
		} else {
		    return true;
		}
			
	}
}