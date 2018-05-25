<?php

/**
 * Essa Classe manipula o Status do Lote.
 * A = Aguardando Atendimento
 * C = Conclu�do
 * @access public
 * 
 * @author Alex Carreira
 */
class Sam_Status_Solicitacao {

    /**
     * Método que retorna o Array com os Status disponíveis para as Solicitaç�es.
     * 
     * @return array
     */
    public static function listaStatus() {
        return array(
            'A' => 'Aguardando Atendimento',
            'C' => 'Conclu&iacute;do',
            'R' => 'Cancelado'
        );
    }

    /**
     * Método que recebe o status do lote no formato int e retorna o nome do 
     * Status no formato string
     * @example Sam_Status_Solicitacao::retornaStatus($statusId);
     * @var int
     * @param int $statusId
     * @return string
     */
    public static function retornaStatus($statusId) {
        $array = self::listaStatus();
        if (isset($array[$statusId])) {
            return $array[$statusId];
        }
        return "[codigo $statusId]";
    }
    
    public static function retornaMotivo($motivoIndex) {
        switch ($motivoIndex) {
            case 'QUEBRACARTAO' :
                return 'Perda ou quebra do cartão';
                break;
            case 'PROBLEMATARJETA' :
                return 'Problema na tarjeta do cartão';
                break;
            case 'ROUBOCARTAO' :
                return 'Roubo do cartão';
                break;
            case 'INFORMACAOINCORRETA' :
                return 'Informações incorretas';
                break;
        }
    }
    
    public static function retornaTipo ($tipoIndex) {
        switch ($tipoIndex) {
            case 'SVCONTRATO' :
                return 'Segunda via de contrato';
                break;
            case 'SVCARTAO' :
                return 'Segunda via de cartão';
                break;
        }
    }

    /**
     * Método que retorna o Array com os Tipos disponíveis para as Solicitaç�es.
     * 
     * @return array
     */
    public static function listaTipo() {
        return array(
            'SVCONTRATO' => 'Segunda via de contrato',
            'SVCARTAO' => 'Segunda via de cartão'
        );
    }

    public static function listaMotivo() {
        return array(
            'QUEBRACARTAO' => 'Perda ou quebra do cartão',
            'PROBLEMATARJETA' => 'Problema na tarjeta do cartão',
            'ROUBOCARTAO' => 'Roubo do cartão',
            'INFORMACAOINCORRETA' => 'Informações incorretas'
        );
    }

}
