<?php

class TrainingController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        $treinamento = new Application_Model_DbTable_Treinamento();
        $this->view->treinamento = $treinamento->fetchAll();
        
        //paginator
        $select = $treinamento->select()->order('id');
        $paginator = Zend_Paginator::factory($select);
        $page = $this->_getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(1);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginatorControl.phtml');
        
        $this->view->paginator = $paginator;
    }

    function viewAction() {
        $request = $this->getRequest();

        $treinamento = new Application_Model_DbTable_Treinamento();
        $id = $request->getParam('id');
        if (!empty($id)) {
            $treinamento = new Application_Model_DbTable_Treinamento();
            $row = $treinamento->find($id);
            $this->view->treinamento = $row->current();
        }
    }

    public function addAction() {

        $request = $this->getRequest();
        $form = new Application_Form_Treinamento();

        if ($request->isPost()) {
            $postData = $request->getParams();
            if ($form->isValid($postData)) {
                $treinamento = new Application_Model_DbTable_Treinamento();
                try {
                    $treinamento->addTraining($postData);
                } catch (Exception $ex) {
                    
                }

                $this->_helper->redirector('index');
            }
        }

        $this->view->form = $form;
    }

    function editAction() {
        $request = $this->getRequest();
        $form = new Application_Form_Treinamento();

        if ($request->isPost()) {
            $postData = $request->getParams();
            if ($form->isValid($postData)) {
                $treinamento = new Application_Model_DbTable_Treinamento();
                try {
                    $treinamento->updateTraining($postData);
                } catch (Exception $ex) {
                    
                }
                $this->_helper->redirector('index');
            } else {
                $form->populate($postData);
            }
        } else {
            $primary = $this->_getParam('id', 0);
            if ($primary > 0) {
                $treinamento = new Application_Model_DbTable_Treinamento();
                $form->populate($treinamento->getTraining($primary));
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
                $treinamento = new Application_Model_DbTable_Treinamento();
                $treinamento->deleteTraining($primary);
            }
            $this->_helper->redirector('index');
        } else {
            $primary = $this->_getParam('id', 0);
            $treinamento = new Application_Model_DbTable_Treinamento();
            $this->view->treinamento = $treinamento->getTraining($primary);
        }
    }

}
