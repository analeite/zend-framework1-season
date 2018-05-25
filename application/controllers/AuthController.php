<?php

class AuthController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        
    }

    public function esqueciAction() {
        $search = $this->getRequest()->getParam('s');
        $tab = new Application_Model_DbTable_Empresa();
        $lista = $tab->fetchAll(array('? in (usuario,email)' => $search));
        if (count($lista) != 1) {
            echo json_encode(array('success' => '0'));
            exit();
        }
        $user = $lista->current()->toArray();
        $newpass = $tab->createPassword();
        $tab->update(array('senha' => md5($newpass)), array('id=?' => $user['id']));
        $tab->emailSendPassword($user['email'], $user['usuario'], $newpass);
        echo json_encode(array('success' => '1', 'email' => $user['email']));
        exit();
    }

    public function loginAction() {
        //instancia o formulario de login
        $this->_helper->layout->disableLayout();
        $form = new Application_Form_Login();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                /**
                 * Instancia o Auth Db Table Adapter
                 *
                 * Quando se instancia este objeto, precisamos informar as configura��es
                 * do BD, nome da tabela onde os dados de login est�o, o campo do nome
                 * do usu�rio, e o campo da senha na tabela.
                 */
                $auth = Zend_Auth::getInstance();

                //$conexao = $this->getInvokeArg('bootstrap')->getDb('db2'); 
                //Zend_Db_Table::setDefaultAdapter($conexao);
                //$resource = $bootstrap->getPluginResource('multidb');
                //$db1 = $resource->getDb('db1');
                //$db2 = $resource->getDb('db2');

                $auth->clearIdentity();

                $dbAdapter = Zend_Registry::get('db');

                $adapter = new Zend_Auth_Adapter_DbTable(
                        $dbAdapter, 'usuario', 'usuario', 'senha'
                );

                $senha = md5($form->getValue('txtPassword'));

                // Configura as credencias informadas pelo usu�rio
                $adapter->setIdentity($form->getValue('txtUserName'));
                $adapter->setCredential($senha);

                // Cria uma instancia de Zend_Auth
                //$auth = Zend_Auth::getInstance();
                // Tenta autenticar o usu�rio
                $result = $auth->authenticate($adapter);


                /**
                 * Se o usu�rio for autenticado redireciona para a index e grava seu email,
                 * caso contr�rio exibe uma mensagem de alerta na p�gina
                 */
                if ($result->isValid()) {
                    $data = $adapter->getResultRowObject((array('id', 'nome', 'usuario', 'senha', 'email', 'perfil', 'senhaAtiva')));

                    //$data->listacontratos="1,2";  
                    // Armazena os dados do usu�rio
                    $auth->getStorage()->write($data);

                    //echo "Login efetuado com sucesso";
                    $this->_redirect('/');
                } else {
                    $this->view->message = 'Usuario/senha invalidos. ERRO';
                }
            }
        }
        $this->view->form = $form;
    }

    function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

    function registerAction() {
        $this->_redirect('/');
    }

}

?>