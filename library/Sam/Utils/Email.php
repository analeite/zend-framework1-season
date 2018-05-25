<?php

/**
 * Classe criada para centralizar o envio de emails, otimizando a manutenção do 
 * código. Essa classe contém todos os métodos Getters e Setters e outros.
 * Os parametros de configuração de e-mail, precisam ser ajustados no arquivo
 * application.ini na pasta config do projeto. Os itens que precisam ser
 * configurados são os seguintes: <br />
 * resources.email.from.address = 'smtp.dominio.com.br'
 * resources.email.from.name = 'Nome que será exibido para o usuaŕio'
 * resources.email.smtp.server = 'smtp.dominio.com.br' <br />
 * 
 * Para utilizar essa classe, seguem abaixo os exemplos:
 * 1º Instanciá-la: 
 *      $mail = new Sam_Utils_Email();
 * 2º Indicar o destino do e-mail: 
 *      $mail->setToAddress('exemplo@dominio.com');
 * 3º Indicar o corpo da mensagem, de acordo com o Tipo:
 *  HTML 
 *      $mail->setHtmlBody('Código HTML');
 *  HTML Template 
 *      $mail->setTemplateVariables(array('variavel1' => 'valor1));
 *      $mail->setBodyTemplate('template.phtml');
 * 4º Indicar o Assunto da Mensagem:
 *      $mail->setSubject('Assunto da Mensagem');
 * 5º Enviar o E-mail
 *      $mail->sendMail(); 
 * 
 * @access public
 * 
 * @author Alex Carreira
 */

require_once 'Zend/Mail.php';
require_once 'Zend/Mail/Transport/Smtp.php';

class Sam_Utils_Email {

    private $mailServer;
    private $htmlBody;
    private $plainBody;
    private $fromAddress;
    private $fromName;
    private $toAddress;
    private $subject;
    private $mailTemplate;
    private $mailTemplateVariables;
    private $accountUsername;
    private $accountPassword;
    private $cryptoSsl;
    private $authType;
    private $mailProvider;
    private $mailServerPort;
    private $mailCharset;
    
    public function __construct()
    {
        $emailParams = Zend_Registry::get('email');
        
        $this->mailProvider = $emailParams['provider'];
        $this->mailCharset = $emailParams['charset'];
        $this->mailServer = $emailParams['smtp']['server']['address'];
        $this->mailServerPort = $emailParams['smtp']['server']['port'];
        $this->accountUsername = $emailParams['account']['username'];
        $this->accountPassword = $emailParams['account']['password'];
        $this->cryptoSsl = $emailParams['crypto']['ssl'];
        $this->authType = $emailParams['auth']['type'];
        $this->fromAddress = $emailParams['from']['address'];
        $this->fromName = $emailParams['from']['name'];
    }
    
    /**
     * Método que será utilizado para enviar e-mails no formato HTML.
     * Quando esse método for utilizado, não utilizar o setPlainBody,
     * não utilizar o setBodyTemplate e nem o setTemplateVariables pois
     * a utilização desse método, implica na adição do código HTML como
     * parâmetro do método.
     * 
     * @param string $htmlBody Código HTML que será exibido no corpo do e-mail
     * @example $mail->setHtmlBody($htmlBody);
     */
    public function setHtmlBody($htmlBody)
    {
        $this->htmlBody = $htmlBody;
    }
    
    private function getHtmlBody()
    {
        return $this->htmlBody;
    }
    
    /**
     * Envia variáveis a view template que foi criada. Essas variáveis funcionam
     * da mesma forma que uma View Comum. Na view, a chamada é feita da mesma forma
     * ou seja: $this->variavel.
     * Quando esse método for utilizado, não utilizar o setPlainBody e também,
     * não utilizar o setHtmlBody.
     * 
     * @param array $variables Array com os parametros que serão passados ao Template
     * @example $mail->setTemplateVariables(array('variavel1' => 'value1'));
     */
    public function setTemplateVariables($variables)
    {
        $this->mailTemplateVariables = $variables;
    }
    
    private function getTemplateVariables()
    {
        return $this->mailTemplateVariables;
    }
    
    /**
     * Para utilizar esse método, é necessário primeiro criar a view que deverá
     * estar localizada na pasta: <b>/application/views/scripts/mail-template</b>
     * Quando esse método for utilizado, não utilizar o setPlainBody e também,
     * não utilizar o setHtmlBody
     * 
     * 
     * @param string $mailTemplate Nome da View que será apontada como template.
     * @example $mail->setBodyTemplate('nome-da-view.phtml');
     */
    public function setBodyTemplate($mailTemplate)
    {
        $this->mailTemplate = $mailTemplate;
    }
    
    private function getBodyTemplate()
    {
        return $this->mailTemplate;
    }
    
    /**
     * Método utilizado para ser enviado no e-mail, texto puro, sem nenhuma
     * formatação.
     * Quando esse método for utilizado, não utilizar o setBodyTemplate, 
     * não utilizar o setTemplateVariables e também não utilizar o setHtmlBody
     * 
     * @param String $plainBody Texto que será enviado no corpo do e-mail
     * @example $mail->setPlainBody('Texto do e-mail') description
     */
    public function setPlainBody($plainBody)
    {
        $this->plainBody = $plainBody;
    }
    
    private function getPlainBody()
    {
        return $this->plainBody;
    }
    
    private function getFromAddress()
    {
        return $this->fromAddress;
    }
    
    /**
     * Nesse método, podemos indicar para qual endereço os e-mails serão enviados.
     * 
     * @param string $toAddress Endereço de E-mail de destino
     * @example $mail->setToAddress('sjc@season.com.br');
     */
    public function setToAddress($toAddress)
    {
        $this->toAddress = $toAddress;
    }
    
    private function getToAddress()
    {
        return $this->toAddress;
    }
    
    /**
     * 
     * @param string $subject Assunto do e-mail
     * @example $mail->setSubject('Assunto do e-mail');
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    private function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * Esse método faz o envio do e-mail.
     * 
     * @example $mail->sendMail()
     */
    public function sendMail()
    {
        if($this->mailProvider == 'unimed') 
        {
            $transport = new Zend_Mail_Transport_Smtp();
            $protocol = new Zend_Mail_Protocol_Smtp($this->mailServer);
            $protocol->connect();
            $protocol->helo($this->mailServer);
            $transport->setConnection($protocol);
        }
        else
        {
            $config = array(
                'ssl' => $this->cryptoSsl,
                'port' => $this->mailServerPort,
                'auth' => $this->authType,
                'username' => $this->accountUsername,
                'password' => $this->accountPassword
            );
            $transport = new Zend_Mail_Transport_Smtp($this->mailServer, $config);
        }
        
        $mail = new Zend_Mail($this->mailCharset);
        
        /**
         * Set Email Body (HTML or Plain Text)
         */
        if(isset($this->htmlBody)) 
        {
            $mail->setBodyHtml($this->getHtmlBody());
        }
        else if(isset($this->mailTemplate))
        {
            /* Set Html Template */
            $htmlTemplate = new Zend_View();
            $htmlTemplate->setScriptPath(APPLICATION_PATH . '/views/scripts/mail-templates/');
            
            $htmlTemplate->assign($this->getTemplateVariables());
            
            $mail->setBodyHtml($htmlTemplate->render($this->getBodyTemplate()));
        }
        else 
        {
            $mail->setBodyText($this->getPlainBody());
        }
        
        /**
         * Set Email To Address
         */
        $mail->addTo($this->getToAddress());
        $mail->setFrom($this->getFromAddress());
        $mail->setSubject($this->getSubject());
        
        /**
         * Sending Email
         */
        if($this->mailProvider == 'unimed')
        {
            $protocol->rset();
        }
        $mail->send($transport);
        
        /**
         * Disconnecting from EmailServer
         */
        if($this->mailProvider == 'unimed')
        {
            $protocol->quit();
            $protocol->disconnect();
        }
    }
}
