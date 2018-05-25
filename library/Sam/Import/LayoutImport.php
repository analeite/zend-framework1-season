<?php

class Sam_Import_LayoutImport {

    private $_config = array();
    private $_filePath;
    private $data = array();
    public $_erro = array();
    public $_filename;
    private $_validate;
    public $_resultado; // linhas corretas
    public $_linhasErradas; //linhas erradas

    /**
     * @return the $_validate
     */

    public function getValidate() {
        return $this->_validate;
    }

    /**
     * @param field_type $_validate
     */
    public function setValidate($_validate) {
        $this->_validate = $_validate;
    }

    /**
     * @return the $_erro
     */
    public function getErro() {
        return $this->_erro;
    }

    /**
     * @param multitype: $_erro
     */
    public function setErro($_erro) {
        $this->_erro = $_erro;
    }

    /**
     * @return the $_linhaserradas
     */
    public function getLinhasErradas() {
        return $this->_linhaserradas;
    }

    /**
     * @param multitype: $_linhaserradas
     */
    public function setLinhasErradas($_linhaserradas) {
        $this->_erro = $_linhaserradas;
    }

    /**
     * @return the $_filename
     */
    public function getFilename() {
        return $this->_filename;
    }

    /**
     * @param multitype: $_filename
     */
    public function setFilename($_filename) {
        $this->_erro = $_filename;
    }

    /**
     * @return the $_resultado
     */
    public function getResultado() {
        return $this->_resultado;
    }

    /**
     * @param multitype: $_resultado
     */
    public function setResultado($_resultado) {
        $this->_resultado = $_resultado;
    }

    /**
     * @return the $_config
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * @return the $_path
     */
    public function getFilePath() {
        return $this->_filePath;
    }

    /**
     * @return the $data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param multitype: $_config
     */
    public function setConfig($_config) {
        $this->_config = $_config;
    }

    /**
     * @param field_type $_filePath
     */
    public function setFilePath($_filePath) {
        $this->_filePath = $_filePath;
    }

    /**
     * @param multitype: $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function setArrayConfig() {
        
    }

    public function addConfig($root, $param = null, $lenght, $type, $begin, $validate = null) {

        if (!array_key_exists($root, $this->_config)) {
            $this->createRoot($root);
        }
        if (!is_null($param)) {
            $this->_config[$root][$param] = array(
                'tamanho' => $lenght,
                'tipo' => $type,
                'inicio' => $begin,
                'validate' => $validate
            );
        } else {
            $this->_config[$root] = array(
                'tamanho' => $lenght,
                'tipo' => $type,
                'inicio' => $begin,
                'validate' => $validate
            );
        }
    }

    public function createRoot($name) {
        if (!array_key_exists($name, $this->_config)) {
            $this->_config[$name] = array();
        }
    }

    public function validateGeral() {
        
    }

    public function geraTxt($erros, $contrato) {
        if (!empty($erros)) {
            $fileName = md5(time() . rand(0, 50)) . ".txt";
            $filePath = __DIR__ . "/../../../application/tmp";
            if (!is_dir($filePath)) {
                mkdir($filePath);
            }
            $nomedoarquivo = $filePath . "/" . $fileName;
            $file = fopen($nomedoarquivo, 'a+');
            //primeira linha do txt
            fwrite($file, $contrato . "\r\n");
            foreach ($erros as $r) {
                fwrite($file, $r . "\r\n");
            }
            fclose($file);
            return $fileName;
        }
    }

    public function import($text) {
        $validate = new $this->_validate();
        $data = array();
        $i = 0;
        $fileArray = preg_split('/\r\n|\n|\r/', $text); //explode("\n", str_replace("\r", "",$text));
        $erros = array();
        $lines = array();
//        $ultimaLinha = rtrim(end($fileArray));
        //pega o nome do controller
        $controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();

        $array_cache_novasfamilias = array();
        $contratoTxt = array();
//              10284600 - id 326012
//               10284700 - id 326020
        $codigoContrato = array(10284600, 10284700);

        foreach ($fileArray as $line) {
            $i++;
            if ($i == 1) {
                /* se for a primeira passagem no foreach o contador i será igual a 1
                  então a linha é atribuida a variável contrato
                  o rtrim vai tirar os espaços à direita do contrato */
                $contrato = rtrim($line);
            }

            /* quando o controller for o import-pj 
              o i ira valer 2, pois no resumo não
             * tem a primeira linha de contrato
             */
            if ($controller == "import-pj") {
                $i = 2;
            }

            //não pega a primeira linha e nem a ultima (header e footer)
            $tamanho = strlen(rtrim($line));
//            if ($i != 1) {

            $import = array();
            $tipo = substr($line, $this->_config['header']['inicio'], $this->_config['header']['tamanho']);

            if (isset($this->_config[$tipo])) {
                foreach ($this->_config[$tipo] as $key => $config) {
                    if ($config['tipo'] == 'int')
                        $import[$key] = (int) substr($line, $config['inicio'], $config['tamanho']);
                    else
                        $import[$key] = trim(substr($line, $config['inicio'], $config['tamanho']));
//     			$import[$key]  = substr ( $line, $config['inicio'],$config['tamanho'] );

                    if (isset($config['validate']) && !empty($config['validate'])) {
                        $val = $validate->validate($import[$key], $config['validate'], $key);

                        foreach ($val as $k => $result) {
                            foreach ($result as $vali => $value) {
                                if (!$value) {
                                    $this->_erro[] = "Erro no campo: $k, no validador: {$vali}, da linha: 	 $i";
                                    $erros[] = $line;
                                }
                            }
                        }
                    }
                }

                /* data para a validação do cpf
                  pega a data de nascimento do txt */
                $nascimento = $import['dt_nascimento']; //a data vem nesse formato ('10101994')

                if (!empty($nascimento)) {
                    //transforma a data do nascimento em timestamp
                    $date = \DateTime::createFromFormat('dmY', $nascimento);
                    $idade = intval((time() - $date->getTimestamp()) / (60 * 60 * 24 * 365));
                }

                // pega os 4 primeiros numeros do cod do titular
                $inicio_titular = substr($import['cod_titular'], 0, 4);

                //pega os 4 primeiros numeros do cod do dependente
                $inicio_dependente = substr($import['cod_dependente'], 0, 4);

                // pega a data do arquivo                   
                $pegaMes = substr($import['fim_vigencia'], 2, 2);
                $pegaDia = substr($import['fim_vigencia'], 0, 2);

                //pega a data atual
                $mesAtual = date('m');
                $diaAtual = date('d');



                if ($import['cod_contrato'] != "") {
                    $contratoTxt[] = $import['cod_contrato'];
                }

                if ($tamanho > 26) {

                    if (!in_array($contratoTxt, $codigoContrato)) {// era pra retornar true... esta retornando false
                        if ($import['codigolotacao'] == '000000000000000') {
                            $this->_erro[] = "O campo Lotação não pode ser nulo na linha $i.";
                            $erros[] = $line;
                        }
                    }

                    if ($import['tp_movimento'] == 1 && $import['cod_titular'] != '00000000000000000') {
                        $this->_erro[] = "Inclusão de titular não pode conter o código do mesmo na linha $i.";
                        $erros[] = $line;
                    }

                    if ($import['tp_movimento'] == 1 && trim($import['mat_empresa']) != "") {
                        $array_cache_novasfamilias[] = $import['mat_empresa'];
                    }


                    if ($import['cod_titular'] == '00000000000000000' && $import['tp_movimento'] == 2) {
                        if (!in_array($import['mat_empresa'], $array_cache_novasfamilias)) {
                            $this->_erro[] = "Dependente sem titular na linha $i.";
                            $erros[] = $line;
                        }
                    }

                    if ($import['tp_movimento'] == 2 && $inicio_titular != '0001' && $import['cod_titular'] != '00000000000000000') {
                        $this->_erro[] = "Deve ser informado um código válido do titular na linha $i.";
                        $erros[] = $line;
                    }

                    if ($import['tp_movimento'] == 3) {
                        if ($inicio_titular != '0001' && $import['cod_dependente'] == '00000000000000000') {
                            $this->_erro[] = "Deve ser informado o código válido do titular na linha $i.";
                            $erros[] = $line;
                        }
                        if ($inicio_dependente != '0001' && $import['cod_titular'] == '00000000000000000') {
                            $this->_erro[] = "Deve ser informado o código válido do dependente na linha $i.";
                            $erros[] = $line;
                        }
                        if ($inicio_dependente == '0001' && $inicio_titular == '0001') {
                            $this->_erro[] = "Não é possível realizar duas alterações de beneficiário na linha $i.";
                            $erros[] = $line;
                        }
                    }

                    if ($import['tp_movimento'] == 4) {
                        if ($inicio_titular != '0001') {//$import['cod_titular'] == '00000000000000000' 
                            $this->_erro[] = "Deve ser informado um código válido de titular na linha $i.";
                            $erros[] = $line;
                        }

                        $mes = date("m");
                        $ano = date("Y"); // Ano atual
                        $ultimo_dia = date("t", mktime(0, 0, 0, $mes, '01', $ano));// ultimo dia
                        $dataExclusao = "$ultimo_dia$mes$ano";
                        $import['fim_vigencia'] = $dataExclusao;
                        
//                        if ($pegaMes != $mesAtual || $pegaDia < $diaAtual) {
//                            $this->_erro[] = "A data de Exclusão só poderá ser até o último dia do mês em que o arquivo está sendo processado na linha $i.";
//                            $erros[] = $line;
//                        }
                    }

                    if ($import['tp_movimento'] == 5) {
                        if ($inicio_dependente != '0001') {
                            $this->_erro[] = "Deve ser informado um código válido de dependente na linha $i.";
                            $erros[] = $line;
                        }

                        
                        $mes = date("m");
                        $ano = date("Y"); // Ano atual
                        $ultimo_dia = date("t", mktime(0, 0, 0, $mes, '01', $ano));// ultimo dia
                        $dataExclusao = "$ultimo_dia$mes$ano";
                        $import['fim_vigencia'] = $dataExclusao;
                        
//                        if ($pegaMes != $mesAtual || $pegaDia < $diaAtual) {
//                            $this->_erro[] = "A data de Exclusão só poderá ser até o último dia do mês em que o arquivo está sendo processado na linha $i.";
//                            $erros[] = $line;
//                        }
                    }

                    if (($import['cpf'] == '00000000000' || $import['cpf'] == null) && $idade >= 18) {
                        $this->_erro[] = "Obrigatório CPF para maiores de 18 anos na linha $i.";
                        $erros[] = $line;
                    }

                    $lines[] = $line;
                    $data[$tipo][] = $import;
                }
            }
//                 
//            }
        }

        /* Remove o valores duplicados no array */
        $linhas_erradas = array_unique($erros);


        /* verifica os dois array e traz o que tem de diferente entre eles
          ou seja, pega as linhas corretas */
        $result = array_diff($lines, $linhas_erradas);

        //linhas corretas
        $this->_resultado = $result;

        //linhas erradas
        $this->_linhaserradas = $linhas_erradas;

        if ($controller == "import-text") {
            //cria um novo arquivo txt, e preenche com as linhas que contem erros
            $this->_filename = $this->geraTxt($linhas_erradas, $contrato);
        }

        if (count($data) == 0)
            $this->_erro[] = "Nenhum registro foi encontrado <br/>";
        else
            $this->setData($data);
        return $data;
    }

}
