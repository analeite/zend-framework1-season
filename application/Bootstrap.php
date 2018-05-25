<?php

require_once("Sam/Acl/Ini.php");
require_once("Sam/Auth/Plugin.php");

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function __construct($application) {
        parent::__construct($application);


        /* ANTIGA CONEX�O 
          private function connectDatabase(){
          $resource = $this->getPluginResource('db');
          $db = $resource->getDbAdapter();
          Zend_Registry::set('db',$db);
          }


          $resource = $bootstrap->getPluginResource('multidb');
          $db1 = $resource->getDb('db1');
          $db2 = $resource->getDb('db2');
         */

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Sam_');
        Zend_Loader::loadFile("fpdf.php", realpath(APPLICATION_PATH . '/../library/fpdf'), true);

        $resource = $this->getPluginResource('multidb');
        $resource->init();

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
        Zend_Registry::set('config', $config);


        //$db = Zend_Db::factory($config->resources->db);
        //$db = Zend_Db::factory($config->resources->multidb->db1);
        Zend_Registry::set('db', $resource->getDb('db1'));
//        Zend_Registry::set('dbcardio', $resource->getDb('db2'));

        $acl_ini = APPLICATION_PATH . '/configs/roles.ini';
        $this->_acl = new Sam_Acl_Ini($acl_ini);
        Zend_Registry::set('zend_acl', $this->_acl);

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sam_Auth_Plugin($this->_acl));

        $this->_auth = Zend_Auth::getInstance();

        $user = null;
        if ($this->_auth->hasIdentity()) {
            // yes ! we get his role
            $user = $this->_auth->getStorage()->read();
            $role = $user->perfil;
        } else {
            // no = guest user
            $role = 'guest';
        }
        Zend_Registry::set('zend_auth_user', $user);
        Zend_Registry::set('role', $role);
    }

    protected function _initView() {
        $view = new Zend_View();
        $view->setEncoding('UTF-8');
        $view->doctype('HTML5');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        return $view;
    }

//    public function _initLocale() {
//
////        setlocale(LC_ALL, 'pt_BR');
//        $locale = new Zend_Locale('pt_BR');
//        Zend_Registry::set('Zend_Locale', $locale);
//        Zend_Locale::setDefault('pt_BR');
//        Zend_Locale_Format::setOptions(array('precision' => 2, 'locale' => 'pt_BR'));
//
//        $translate = new Zend_Translate(
//                array(
//            'adapter' => 'array',
//            'content' => APPLICATION_PATH . '/configs/translate/ptBr.php',
//            'locale' => 'pt_br'
//                )
//        );
//        Zend_Registry::set('Zend_Translate', $translate);
//    }

}

