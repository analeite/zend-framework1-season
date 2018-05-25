<?php

/**
 * Essa Classe manipula o Status do Lote.
 * 0 = Processados pela Unimed
 * 1 = Aguardando Análise
 * 2 = Aguardando Documentos
 * 3 = Cancelados
 * 4 = Pendente RC
 * @access public
 * 
 * @author Alex Carreira
 */
class Sam_Formatter_Mask {

    public static function mascara($val, $mask) {
        $masquerade = '';
        $k = 0;
        if (!empty($val)) {
            for ($i = 0; $i <= strlen($mask) - 1; $i++) {
                if ($mask[$i] == '#') {
                    if (isset($val[$k]))
                        $masquerade .= $val[$k++];
                }
                else {
                    if (isset($mask[$i]))
                        $masquerade .= $mask[$i];
                }
            }
        }
        return $masquerade;
    }

}
