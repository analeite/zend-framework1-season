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
class Sam_Status_Lote {

    /**
     * Método que retorna o Array com os Status disponíveis para os Lotes.
     * 
     * @return array
     */
    public static function listaStatus() {
        return array('1' => 'Aguardando Analise', '2' => 'Aguardando Documentos', '4' => 'Pendente RC', '0' => 'Processados pela Unimed', '3' => 'Cancelados');
    }

    /**
     * Método que recebe o status do lote no formato int e retorna o nome do 
     * Status no formato string
     * @example Sam_Status_Lote::retornaStatus($loteStatus);
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

}
