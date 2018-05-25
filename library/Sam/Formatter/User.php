<?php

/**
 * Essa Classe manipula o Status do Lote.
 * U = Empresa
 * F = Filial
 * A = Admin  
 * I = Interno 
 * R = Relacionamento
 * B = null
 * O = Operadores
 * 
 * @access public
 * 
 * @author Alex Carreira
 */
class Sam_Formatter_User {

    public static function Profile($profile) 
    {
        switch($profile) {
            case 'U':
                return 'Empresa';
                break;
            
            case 'F':
                return 'Filial';
                break;
            
            case 'A':
                return 'Admin';
                break;
            
            case 'I':
                return 'Interno';
                break;
            
            case 'R':
                return 'Relacionamento';
                break;
            
            case 'O':
                return 'Operadores';
                break;
            
            case 'B':
                return 'B';
                break;
        }
    }
    
    public static function retornaPerfilEmpresa()
    {
        $profile = array('U', 'F');
        return $profile;
    }

    public static function retornaPerfilUsuario()
    {
        $profile = array('I','R','A','O');
        return $profile;
    }
}
