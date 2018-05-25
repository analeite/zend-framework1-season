<?php

class Sam_Mail {
    
    private $_transport = null;
    
    public function getTransport(){
        if ( $this->_transport == null ){
            $param = new Application_Model_DbTable_Params();
            $configs = array('port'=>$param->getParam('SMTP_PORT'));
            $SMTP_AUTH = $param->getParam('SMTP_AUTH');
            if ( !empty($SMTP_AUTH) ){
                $configs['auth'] = $SMTP_AUTH;    
                $configs['username'] = $param->getParam('SMTP_USERNAME');
                $configs['password'] = $param->getParam('SMTP_PASSWORD');
                $ssl = $param->getParam('SMTP_SSL');
                if ( !empty($ssl) )
                    $configs['ssl'] = $ssl;
            }
            $this->_transport = new Zend_Mail_Transport_Smtp(
                    $param->getParam('SMTP_HOST'),
                    $configs);
        }
        return $this->_transport;
    }
    
    public function send($to,$subject,$body,$tags = array()){
        foreach ($tags as $k => $v){
            $body = str_replace('##'.$k.'##', $v, $body);
        }
        $param = new Application_Model_DbTable_Params();
        $mail = new Zend_Mail();
        $mail->setBodyHtml($body);
        $mail->addTo($to);
        
        $reply =  $param->getParam('SMTP_REPLY');
        if ( empty($reply) )
            $mail->setReplyTo($reply);

        $mail->setFrom($param->getParam('SMTP_FROM'), $param->getParam('SMTP_FROM_NAME'));
        $mail->setSubject($subject);

        return $mail->send($this->getTransport());
    }
}