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
class Zend_View_Helper_Usuario extends Zend_View_Helper_Abstract {

    /**
     * Método Principal
     * @param string $value Valor para Formatação
     * @return string Valor Formatado
     */
    public function usuario($value) {
        
        switch ($value) {
            case 'A':
                return 'Administrador';
                break;
            case 'U':
                return 'Usuário';
                break;
        }
    }
}