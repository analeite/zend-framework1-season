<?php


require_once 'PHPExcel/PHPExcel.php';
/**
 * Description of Excel
 *
 * @author alex
 */
class Sam_Utils_Excel {

    public function gerarExcel($colunas, $linhas, $plan_name) {
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Season");
        $objPHPExcel->getProperties()->setLastModifiedBy("Season");
        $objPHPExcel->getProperties()->setTitle($plan_name);

        // Titulo da Planilha
        $objPHPExcel->getActiveSheet()->setTitle($plan_name);

        $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );
        
        // Configurar font das células / cabeçalho
        $objPHPExcel->setActiveSheetIndex(0);
        $letra = "A";
        for ($i = 0; $i < count($colunas); $i++) {
            $sigla = $letra . "1";
            $objPHPExcel->getActiveSheet()->getStyle($sigla)->getFont()->setColor(new PHPExcel_Style_Color('FFFFFF'));
            $objPHPExcel->getActiveSheet()->getStyle($sigla)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle($sigla)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle($sigla)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($sigla)->getFill()->getStartColor()->setARGB('000000');
            $objPHPExcel->getActiveSheet()->setCellValue($sigla, $colunas[$i]);
            $letra++;
        }
        

        $i = 2;
        foreach ($linhas as $linha) {
            $newLinha = array();
            $sigla = "A" . $i;
            //inserir linhas, inserir valores em branco para posições que não existem em outras linhas
            foreach ($colunas as $coluna) {
                if (array_key_exists($coluna, $linha)) {
                    $newLinha[] = $linha[$coluna];
                } else {
                    $newLinha[] = "";
                }
            }
            $objPHPExcel->getActiveSheet()->fromArray($newLinha, NULL, $sigla);
            $i++;
        }
        
        foreach(range('A','Z') as $columnID) {
            $objPHPExcel->getSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        //criar arquivo excel
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        return $objWriter;
    }

}
