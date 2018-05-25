<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RDP
 *
 * @author alex
 */
class Sam_Formatter_RDP {

    public static function NomeRDP($rdp) {
        if ($rdp == 0) {
            return "Titular";
        }
        if ($rdp == 1) {
            return "Esposa";
        }
        if ($rdp == 2) {
            return "Companheiro(a)";
        }
        if ($rdp == 9) {
            return "Esposo";
        }
        if ($rdp >= 10 and $rdp <= 29) {
            return "Filho";
        }
        if ($rdp >= 30 and $rdp <= 49) {
            return "Filha";
        }
        if ($rdp == 50) {
            return "Pai";
        }
        if ($rdp == 51) {
            return "Mae";
        }
        if ($rdp == 52) {
            return "Sogro";
        }
        if ($rdp == 53) {
            return "Sogra";
        }
        if ($rdp >= 60 and $rdp <= 69) {
            return "Outra Dependencia";
        }
        if ($rdp >= 70 and $rdp <= 74) {
            return "Filho(a) Adotivo(a)";
        }
        if ($rdp >= 75 and $rdp <= 79) {
            return "Enteado(a)";
        }
        if ($rdp >= 80 and $rdp <= 89) {
            return "Irmao(a)";
        }
        if ($rdp >= 90 and $rdp <= 99) {
            return "Agregado";
        }
    }

}
