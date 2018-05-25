<?php

class Sam_Relatorio extends FPDF {

    function BasicTable($data, $dadosSup, $lista) {
        $this->SetMargins(7, 7, 7);
        $this->Ln();
        $this->Ln();

        //Dados do titular
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 6, utf8_decode('Titular:'), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 6, utf8_decode($data[0]["Nome"]), 0, 0, 'L');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 6, utf8_decode(utf8_encode('Cod Transa��o:')), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(90, 6, utf8_decode($dadosSup['id']), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 6, utf8_decode('Data de envio:'), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 6, utf8_decode($dadosSup['dt_criacao']), 0, 0, 'L');
        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 6, utf8_decode('Status:'), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(90, 6, utf8_decode($lista[$dadosSup['status']]), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 6, utf8_decode(utf8_encode('N�mero do cart�o:')), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 6, utf8_decode($dadosSup['cartao']), 0, 0, 'L');
        $this->Ln();
        $this->Ln();


        $campos["Nome"] = 'Nome';
        $campos["DataNascimento"] = 'Data de Nascimento';
        $campos["Cnp"] = 'CPF';
        $campos["Sexo"] = 'Sexo';
        $campos["EstadoCivil"] = 'Estado Civil';
        $campos["Naturalidade"] = 'Naturalidade Id';
        $campos["NomeCidade"] = 'Naturalidade Nome';
        $campos["UF"] = 'Naturalidade UF';
        $campos["NomePai"] = 'Nome do Pai';
        $campos["NomeMae"] = 'Nome da Mãe';
        $campos["NomeConjuge"] = 'Nome da Conjuge';
        $campos["End_Seq"] = 'Seq. do Endereço';
        $campos["End_Logradouro"] = 'Logradouro';
        $campos["End_NumLogradouro"] = 'Numero Endereço';
        $campos["End_ComplLogradouro"] = 'Complemento';
        $campos["End_Bairro"] = 'Bairro';
        $campos["End_Cidade"] = 'Cidade Id';
        $campos["End_NomeCidade"] = 'Cidade';
        $campos["End_UF"] = 'UF';
        $campos["End_CEP"] = 'CEP';
        $campos["End_PontoReferencia"] = 'Ponto de Referencia';
        $campos["End_CaixaPostal"] = 'Caixa Postal';
        $campos["End_Tipo"] = 'Tipo Endereço';
        $campos["Tel_Fixo_Seq"] = 'Seq. do Telefone Fixo';
        $campos["Tel_Fixo_DDD"] = 'DDD Fixo';
        $campos["Tel_Fixo_Numero"] = 'Telefone Fixo';
        $campos["Tel_Cel_DDD"] = 'DDD Cel';
        $campos["Tel_Cel_Numero"] = 'Telefone Cel';
        $campos["RG"] = 'Nr. do Documento';
        $campos["RG_UF"] = 'UF do Documento';
        $campos["PIS"] = 'Nr. PIS';
        $campos["cns"] = 'Nr. CNS';
        $campos["Email"] = 'Email';


        foreach ($data as $pos => $values) {
            if ($pos % 2 == 0) {
                if ($pos != 0) {
                    $this->AddPage();
                }
                $this->Cell(197, 6, $data[$pos]['Nome'], 1);
                $this->Ln();
                $this->Cell(45, 6, utf8_decode('Campo'), 1, 0, 'C');
                $this->Cell(76, 6, utf8_decode('Valor Antigo'), 1, 0, 'C');
                $this->Cell(76, 6, utf8_decode('Novo Valor'), 1, 0, 'C');
                $this->Ln();
                foreach ($values as $field => $value) {
                    if ($value != $data[$pos + 1][$field] && $field != 'Nome') {
                        if (array_key_exists($field, $campos)) {
                            $this->Cell(45, 6, utf8_decode($campos[$field]), 1, 0, 'L');
                            $this->Cell(76, 6, utf8_decode($value), 1, 0, 'C');
                            $this->Cell(76, 6, utf8_decode($data[$pos + 1][$field]), 1, 0, 'C');
                            $this->Ln();
                        }
                    }
                }
            }
        }
    }

    function Header() {
        $this->Image('../public_html/imagens/pequeno.png', 10, 10);
        $this->Ln(10);
        $this->SetFont('Helvetica', '', 16);
        $this->Cell(240, 6, utf8_decode(utf8_encode('Movimenta��o Cadastral - Pessoa F�sica')), 0, 2, 'C');
        $this->SetFont('Helvetica', '', 10);
        $this->Ln(12);
    }

    function Footer() {
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->Cell(187, 3, utf8_decode('Unimed Santos - Av. Dona Ana Costa, 211 - Encruzilhada - Santos - SP'), 0, 2, 'C');
        $this->Ln();
        $this->Cell(187, 3, utf8_decode('Cep: 11.060-001 - Tels.: (13) 2102-8100 / 8300'), 0, 2, 'C');
    }

}
