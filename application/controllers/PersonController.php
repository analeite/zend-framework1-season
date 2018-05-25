<?php

class PersonController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        $pessoa = new Application_Model_DbTable_Pessoa();
        $this->view->pessoa = $pessoa->fetchAll();
    }

    function viewAction() {
        $request = $this->getRequest();

        $pessoa = new Application_Model_DbTable_Pessoa();
        $id = $request->getParam('id');
        if (!empty($id)) {
            $pessoa = new Application_Model_DbTable_Pessoa();
            $row = $pessoa->fetchRow(array('id' => $id));
            $this->view->pessoa = $row;
        }
    }

    public function addAction() {

        $request = $this->getRequest();
        $form = new Application_Form_Pessoa();

        if ($request->isPost()) {
            $postData = $request->getParams();
            if ($form->isValid($postData)) {
                $pessoa = new Application_Model_DbTable_Pessoa();
                try {
                    $pessoa->addPerson($postData);
                } catch (Exception $ex) {
                    
                }

                $this->_helper->redirector('index');
            }
        }

        $this->view->form = $form;
    }

    function editAction() {
        $request = $this->getRequest();
        $form = new Application_Form_Pessoa();

        if ($request->isPost()) {
            $postData = $request->getParams();
            if ($form->isValid($postData)) {
                $pessoa = new Application_Model_DbTable_Pessoa();
                try {
                    $pessoa->updatePerson($postData);
                } catch (Exception $ex) {
                    
                }
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $primary = $this->_getParam('id', 0);
            if ($primary > 0) {
                $pessoa = new Application_Model_DbTable_Pessoa();
                $form->populate($pessoa->getPerson($primary));
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del');
            if ($del == 'Sim') {
                $primary = $this->getRequest()->getPost('id');
                $pessoa = new Application_Model_DbTable_Pessoa();
                $pessoa->deletePerson($primary);
            }
            $this->_helper->redirector('index');
        } else {
            $primary = $this->_getParam('id', 0);
            $pessoa = new Application_Model_DbTable_Pessoa();
            $this->view->pessoa = $pessoa->getPerson($primary);
        }
    }

}
