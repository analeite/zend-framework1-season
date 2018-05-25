<?php

class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract {

    protected $_name = 'usuario'; //Sempre é o nome da tabela
    protected $_primary = 'id'; //Sempre é a chave primária da tabela

    public function getUser($primary) {
        $primary = (int) $primary;
        $row = $this->fetchRow('id= ' . $primary);
        if (!$row) {
            throw new Exception("Não foi possível encontrar o ID $primary");
        }
        $data = array(
            'id' => $row->id,
            'nome' => $row->nome,
            'usuario' => $row->usuario,
            'senha' => $row->senha,
            'email' => $row->email,
            'perfil' => $row->perfil,
            'senhaAtiva' => $row->senhaAtiva,
            'observacao' => $row->observacao,
        );
        return $data;
    }

    public function addUser($data) {
        $data = array(
            'nome' => $data['nome'],
            'usuario' => $data['usuario'],
            'senha' => $data['senha'],
            'email' => $data['email'],
            'perfil' => $data['perfil'],
            'senhaAtiva' => $data['senhaAtiva'],
            'observacao' => $data['observacao'],
        );
        $this->insert($data);
    }

    public function updateUser($data) {
        $data = array(
            'id' => $data['id'],
            'nome' => $data['nome'],
            'usuario' => $data['usuario'],
            'senha' => $data['senha'],
            'email' => $data['email'],
            'perfil' => $data['perfil'],
            'senhaAtiva' => $data['senhaAtiva'],
            'observacao' => $data['observacao'],
        );
        $this->update($data, 'id = ' . (int) $data['id']);
    }

    public function deleteUser($primary) {
        $this->delete('id = ' . (int) $primary);
    }

}
