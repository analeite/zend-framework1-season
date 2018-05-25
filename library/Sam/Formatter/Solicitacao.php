<?php

/**
 * Description of Solicitacao
 *
 * @author alex
 */
class Sam_Formatter_Solicitacao 
{
    
    public static function tipoSolicitacao($tipo)
    {
        switch($tipo){
            case 'SVCONTRATO':
                return 'Segunda via de Contrato';
                break;
            case 'SVCARTAO':
                return 'Segunda via de Cartão';
                break;
        }
    }
    
    public static function status($status)
    {
        switch($status){
            case 'A':
                return 'Aguardando atendimento';
                break;
            case 'C':
                return 'Concluído';
                break;
            case 'R':
                return 'Cancelado';
                break;
        }
    }
    
    public static function motivo($motivo)
    {
        switch($motivo) {
            case 'QUEBRACARTAO':
                return 'Perda ou quebra do cartão';
                break;
            case 'PROBLEMATARJETA':
                return 'Problema na tarjeta do cartão';
                break;
            case 'ROUBOCARTAO':
                return 'Roubo do cartão';
                break;
            case 'INFORMACAOINCORRETA':
                return 'Informações incorretas';
                break;
        }
    }
}
