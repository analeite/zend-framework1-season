<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Formatação de Perfil de Usuário
 * Auxiliar da Camada de Visualização
 * @author Alex Carreira Guimarães
 */
class Zend_View_Helper_Mascara extends Zend_View_Helper_Abstract {

    /**
     * Método Mascara
     * @param string $value Valor para Formatação
     * @return string Valor Formatado
     */
    public function mascara($val, $mask) {
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
