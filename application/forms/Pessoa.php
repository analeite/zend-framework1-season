<?php

class Application_Form_Pessoa extends Zend_Form
{
    public function init() {
        $this->setName('pessoa');
        
        $name = new Zend_Form_Element_Text('nome');
        $name->setLabel('Nome')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $date = new Zend_Form_Element_Text('dataNascimento');
        $date->setLabel('Data de Nascimento')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'id' => 'data',
                    'data-mask' => '00/00/0000'
                ));
        
        $telephone = new Zend_Form_Element_Text('telefone');
        $telephone->setLabel('Telefone')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
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
        
        $typePerson = new Zend_Form_Element_Select('tipoPessoa');
        $typePerson->setLabel('Tipo de Pessoa')
                ->addMultiOptions(array(
                    'A' => 'Aluno',
                    'I' => 'Instrutor'
                ))
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $note = new Zend_Form_Element_Textarea('observacao');
        $note->setLabel('Observação')
                ->setRequired(true)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'rows' => 4
                ));
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setAttrib('id', 'submitbutton')
                ->setAttribs(array(
                    'class' => 'btn btn-block btn-primary'
                ));
        
        $this->addElements(array($name, $date, $telephone, $email, $typePerson, $note, $submit));
        
    }
}

