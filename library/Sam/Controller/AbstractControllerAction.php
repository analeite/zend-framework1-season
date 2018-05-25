<?php

class Sam_Controller_AbstractControllerAction extends Zend_Controller_Action 
{
    public function init() {
        $this->view->controllerName = $this->_request->getControllerName();
        Zend_Layout::getMvcInstance()->setLayout('layout_admin');
    }
    
    public function gravaLog($content) 
    {
        $log = new Application_Model_DbTable_SysLog();
        $log->setLog(null,$content);
    }
}