<?php

class UsersController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        $usuario = new Application_Model_DbTable_Usuario();
        $this->view->usuario = $usuario->fetchAll();
        
        //paginator
//        $data = range(1, 50);
        $select = $usuario->select()->order('id');
        $paginator = Zend_Paginator::factory($select);
        $page = $this->_getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
//        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(1);
        $paginator->setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginatorControl.phtml');
        
        $this->view->paginator = $paginator;
    }

    function viewAction() {
        $request = $this->getRequest();

        $usuario = new Application_Model_DbTable_Usuario();
        $id = $request->getParam('id');
        if (!empty($id)) {
            $usuario = new Application_Model_DbTable_Usuario();
            $row = $usuario->find($id);
            $this->view->usuario = $row->current();
        }
    }

    public function addAction() {

        $request = $this->getRequest();
        $form = new Application_Form_Usuario();

        if ($request->isPost()) {
            $postData = $request->getParams();
            if ($form->isValid($postData)) {
                $usuario = new Application_Model_DbTable_Usuario();
                try {
                    $usuario->addUser($postData);
                } catch (Exception $ex) {
                    
                }

                $this->_helper->redirector('index');
            }
        }

        $this->view->form = $form;
    }

    function editAction() {
        $request = $this->getRequest();
        $form = new Application_Form_Usuario();

        if ($request->isPost()) {
            $postData = $request->getParams();
            if ($form->isValid($postData)) {
                $usuario = new Application_Model_DbTable_Usuario();
                try {
                    $usuario->updateUser($postData);
                } catch (Exception $ex) {
                    
                }
                $this->_helper->redirector('index');
            } else {
                $form->populate($postData);
            }
        } else {
            $primary = $this->_getParam('id', 0);
            if ($primary > 0) {
                $usuario = new Application_Model_DbTable_Usuario();
                $form->populate($usuario->getUser($primary));
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
                $usuario = new Application_Model_DbTable_Usuario();
                $usuario->deleteUser($primary);
            }
            $this->_helper->redirector('index');
        } else {
            $primary = $this->_getParam('id', 0);
            $usuario = new Application_Model_DbTable_Usuario();
            $this->view->usuario = $usuario->getUser($primary);
        }
    }

}
