<?php

class Application_Model_DbTable_Treinamento extends Zend_Db_Table_Abstract {

    protected $_name = 'treinamento'; //Sempre é o nome da tabela
    protected $_primary = 'id'; //Sempre é a chave primária da tabela

    public function getTraining($primary) {
        $primary = (int) $primary;
        $row = $this->fetchRow('id= ' . $primary);
        if (!$row) {
            throw new Exception("Não foi possível encontrar o ID $primary");
        }
        $data = array(
            'id' => $row->id,
            'nomeCurso' => $row->nomeCurso,
            'publicoAlvo' => $row->publicoAlvo,
            'objetivo' => $row->objetivo,
            'requisitos' => $row->requisitos,
            'cargaHoraria' => $row->cargaHoraria,
            'conteudo' => $row->conteudo,
        );
        return $data;
    }

    public function addTraining($data) {
        $data = array(
            'nomeCurso' => $data['nomeCurso'],
            'publicoAlvo' => $data['publicoAlvo'],
            'objetivo' => $data['objetivo'],
            'requisitos' => $data['requisitos'],
            'cargaHoraria' => $data['cargaHoraria'],
            'conteudo' => $data['conteudo'],
        );
        $this->insert($data);
    }

    public function updateTraining($data) {
        $data = array(
            'id' => $data['id'],
            'nomeCurso' => $data['nomeCurso'],
            'publicoAlvo' => $data['publicoAlvo'],
            'objetivo' => $data['objetivo'],
            'requisitos' => $data['requisitos'],
            'cargaHoraria' => $data['cargaHoraria'],
            'conteudo' => $data['conteudo'],
        );
        $this->update($data, 'id = ' . (int) $data['id']);
    }

    public function deleteTraining($primary) {
        $this->delete('id = ' . (int) $primary);
    }

}
