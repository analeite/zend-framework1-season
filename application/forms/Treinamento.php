<?php

class Application_Form_Treinamento extends Zend_Form
{
    public function init() {
        $this->setName('treinamento');
        
        $trainingName = new Zend_Form_Element_Text('nomeCurso');
        $trainingName->setLabel('Nome Curso')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $targetAudience = new Zend_Form_Element_Text('publicoAlvo');
        $targetAudience->setLabel('Público Alvo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $goal = new Zend_Form_Element_Text('objetivo');
        $goal->setLabel('Objetivo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $requirements = new Zend_Form_Element_Textarea('requisitos');
        $requirements->setLabel('Requisitos')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'rows' => 2
                ));
        
        $workload = new Zend_Form_Element_Text('cargaHoraria');
        $workload->setLabel('Carga Horária')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));
        
        $content = new Zend_Form_Element_Textarea('conteudo');
        $content->setLabel('Conteúdo Programático')
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
        
        $this->addElements(array($trainingName, $targetAudience, $goal, $requirements, $workload, $content, $submit));
        
    }
}

