<?php


class Sam_Controller_AbstractClienteControllerAction extends Zend_Controller_Action {
    
    public function init()
    {
        $this->view->controllerName = $this->_request->getControllerName();
        Zend_Layout::getMvcInstance()->setLayout('cliente');
    }
}
