<?php

class Application_Model_DbTable_Pessoa extends Zend_Db_Table_Abstract {

    protected $_name = 'pessoa'; //Sempre é o nome da tabela
    protected $_primary = 'id'; //Sempre é a chave primária da tabela

    public function getPerson($primary) {
        $primary = (int) $primary;
        $row = $this->fetchRow('id= ' . $primary);
        if (!$row) {
            throw new Exception("Não foi possível encontrar o ID $primary");
        }
        $dateObj = new DateTime();
        $dateObj->setTimestamp($row->dataNascimento);
        $data = array(
            'id' => $row->id,
            'nome' => $row->nome,
            'dataNascimento' => $dateObj->format('d/m/Y'),
            'telefone' => $row->telefone,
            'email' => $row->email,
            'tipoPessoa' => $row->tipoPessoa,
            'observacao' => $row->observacao,
        );
        return $data;
    }

    public function addPerson($data) {
        $dateObj = DateTime::createFromFormat('d/m/Y', $data['dataNascimento']);
        $data = array(
            'nome' => $data['nome'],
            'dataNascimento' => $dateObj->getTimestamp(),
            'telefone' => $data['telefone'],
            'email' => $data['email'],
            'tipoPessoa' => $data['tipoPessoa'],
            'observacao' => $data['observacao'],
        );
        $this->insert($data);
    }

    public function updatePerson($data) {
        $dateObj = DateTime::createFromFormat('d/m/Y', $data['dataNascimento']);
        $data = array(
            'id' => $data['id'],
            'nome' => $data['nome'],
            'dataNascimento' => $dateObj->getTimestamp(),
            'telefone' => $data['telefone'],
            'email' => $data['email'],
            'tipoPessoa' => $data['tipoPessoa'],
            'observacao' => $data['observacao'],
        );
        $this->update($data, 'id = ' . (int) $data['id']);
    }

    public function deletePerson($primary) {
        $this->delete('id = ' . (int) $primary);
    }

}
