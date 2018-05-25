<?php

class Sam_Import_ValidateGPA extends Sam_Import_LayoutValidate {

    private $_return = array();

    
    public function required($value) {
        if ( trim($value) != "")
            return true;
        else 
            return false;
        if (!empty($value)) { // && $value
            return true;
        }
        return false;
    }

    public function isString($value) {

        if (is_string($value))
            return true;
        return false;
    }

    public function isInt($value) {

        if (is_int($value))
            return true;
        return false;
    }

    public function sexo($value) {
        if ($value == 'M' || $value == 'F')
            return true;
        else
            return false;
    }
 //var $dtNascimento ;
    public $dtNasc2;
    
    public function dtNascimento($value) {
        
        $dtNasc = (string)$value;
        $this->dtNasc2=  $dtNasc;

        if (intval($value) == 00000000) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function graudependencia($value) {
        if (intval($value) >= 0 && intval($value) <= 11)
            return true;
        else
            return false;
    }

    public function contrato($value) {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read();
        if ($user->perfil != 'A') {
            $value = intval($value);
            $other = intval($user->codigo);
            //$other = intval(substr ($user->codigo,0,  strlen($user->codigo)-2));
            if ($value == $other) {
                return true;
            } else
                die ($value .'!='.$other );
                return false;
        } else
            return true;
    }
    
    public function cpf($value) {
                
        $cpf = (string) $value;
        
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        
        $dataHoje= date();
        $dataHoje=  str_replace($dataHoje, '/', '');

        $d = substr($this->dtNasc2, -8, 2);
        $dh = substr($dataHoje,-8,2);
        $m = substr($this->dtNasc2, -6, 2);
        $mh = substr($dataHoje, -6, 2);
        $a = substr($this->dtNasc2, -4 );
        $ah = substr($dataHoje, -4 );
        
        
        if ($ah > $a)
        {
            if($m < $mh)
            {
                if($d < $dh)
                {
                   $idade =  $ah - $a;  
                }
                else 
                {
                $idade =  $a - $ah - 1;
                }
            }
        
        }
        else $idade = 1;
        
       
        if ($idade >= 18 && $cpf == '00000000000' ) {
            return false;
        } elseif ($idade < 18 && $cpf == '00000000000') {
            return true;
        } else {
            // verificar por dígitos iguauis
            $regex = "/^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/";
            if (preg_match($regex, $cpf)) {
                return false;
            }


            $tcpf = $cpf;
            $b = 0;
            $c = 11;
            for ($i = 0; $i < 11; $i++) {
                if ($i < 9) {
                    $b += ($tcpf[$i] * --$c);
                }
            }

            $x = $b % 11;
            $tcpf[9] = ($x < 2) ? 0 : 11 - $x;

            $b = 0;
            $c = 11;
            for ($y = 0; $y < 10; $y++) {
                $b += ($tcpf[$y] * $c--);
            }

            $x = $b % 11;
            $tcpf[10] = ($x < 2) ? 0 : 11 - $x;


            if (($cpf[9] != $tcpf[9]) || ($cpf[10] != $tcpf[10])) {
                return false;
            }
            return true;
        }
    }

    public function pis($value) {
        if ($value != '00000000000000000' && trim($value) != "") {
            $pis = substr($value,-11);
            // somente números
            $pis = preg_replace('/[^0-9]/', '', $pis);
            $pis = str_pad($pis, 11, '0', STR_PAD_LEFT);

            if (strlen($pis) != 11 || intval($pis) == 0) {
                return false;
            } else {
                for ($d = 0, $p = 3, $c = 0; $c < 10; $c++) {
                    $d += $pis{$c} * $p;
                    $p = ($p < 3) ? 9 : --$p;
                }

                $d = ((10 * $d) % 11) % 10;
                if (!($pis{$c} == $d)) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return TRUE;
        }
    }
    public $existeRG;
    public function rg($value) {
        if(trim($value) != '')
        {
            $this->existeRG = 1;
            return true;
        }
        else
        {
           $this->existeRG = 0;
           return true; 
        }
            
    }
    public function docRG($value){
        if($this->existeRG == 1)
        {
        if (!empty($value) && $value) {
            return true;
        }
        return false;
        }
        return true;
    }
}
