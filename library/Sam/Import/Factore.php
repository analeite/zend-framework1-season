<?php

class Sam_Import_Factore
{
    static function createLayout( $contrato ){
//        if ( $contrato == '294846'){
//            return new Sam_Import_LayoutCasasBahia();
//        }
//        
        if ( in_array($contrato, array('326012','326020', '294846'))){ // 294846 layout via varejo
        /*if ( $contrato == '294846'){
            return new Sam_Import_LayoutCasasBahia();
        }*/
        
        if ( in_array($contrato, array('326012','326020','294846'))){
            return new Sam_Import_LayoutGPA();
        }
        
        throw new Exception("Layout nao encontrado para contrato $contrato");
        }
    
    }
}