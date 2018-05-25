<?php 
class Sam_Validate_Pis extends Zend_Validate_Abstract
{
	const PIS_INVALIDO = "pis_invalido";
	
	protected $_messageTemplates = array (
		self::PIS_INVALIDO => "PIS Inválido"
	);

	public function isValid($value)
	{
		
		$pis = trim($value);
		// somente números
		$pis = preg_replace('/[^0-9]/', '', $pis);
		$pis = str_pad($pis, 11, '0', STR_PAD_LEFT);
		
	    if (strlen($pis) != 11 || intval($pis) == 0) {
	        return false;
	    } else {
	        for ($d = 0, $p = 3, $c = 0; $c < 10; $c++) {
	            $d += $pis{$c} * $p;
	            $p  = ($p < 3) ? 9 : --$p;
	        }
	
	        $d = ((10 * $d) % 11) % 10;
	        if ( !($pis{$c} == $d) ){
		        $this->_error(self::PIS_INVALIDO);
		        return  false;
	        } else {
	        	return true;
	        }
	    }
	}
}