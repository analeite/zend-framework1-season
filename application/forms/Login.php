<?php

class Application_Form_Login extends Zend_Dojo_Form {

    public function init() {
        $this->setName('frmLogin');
        $this->setMethod('post');
        $username = new Zend_Dojo_Form_Element_ValidationTextBox('txtUserName');
        $username->setLabel('Usuário')
                ->setRequired(true)
                ->setRegExp("[\w\d]*")
                ->setAttribs(array(
                    'class' => 'form-control'
                ));

        $password = new Zend_Dojo_Form_Element_PasswordTextBox('txtPassword');
        $password->setLabel('Senha')
                ->setRequired(true)
                ->setRegExp("[\d\w]*")
                ->setAttribs(array(
                    'class' => 'form-control'
                ));


        $submit = new Zend_Dojo_Form_Element_SubmitButton('Acessar');
        $submit->setAttrib('class', 'btn btn-lg btn-primary btn-block');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($username, $password, $submit));
    }

}
