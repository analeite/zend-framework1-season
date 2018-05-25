<?php

class Application_Form_Usuario extends Zend_Form
{
    public function init() {
        $this->setName('usuario');
        
        $name = new Zend_Form_Element_Text('nome');
        $name->setLabel('Nome')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $user = new Zend_Form_Element_Text('usuario');
        $user->setLabel('Usuário')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $password = new Zend_Form_Element_Password('senha');
        $password->setLabel('Senha')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-Mail')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $profile = new Zend_Form_Element_Select('perfil');
        $profile->setLabel('Perfil')
                ->addMultiOptions(array(
                    'U' => 'Usuário',
                    'A' => 'Administrador'
                ))
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $activePassword = new Zend_Form_Element_Select('senhaAtiva');
        $activePassword->setLabel('Usuário Ativo?')
                ->addMultiOptions(array(
                    1 => 'Sim',
                    0 => 'Não'
                ))
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $note = new Zend_Form_Element_Textarea('observacao');
        $note->setLabel('Observação')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'rows' => 4
                ));
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setAttrib('id', 'submitbutton')
                ->setAttribs(array(
                    'class' => 'btn btn-block btn-primary'
                ));
        
        $this->addElements(array($name, $user, $password, $email, $profile, $activePassword, $note, $submit));
        
    }
}

