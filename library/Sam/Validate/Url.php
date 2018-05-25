<?php

class Sam_Validate_Url extends Zend_Validate_Abstract {

    const URL_INVALIDO = "url_invalido";

    protected $_messageTemplates = array(
        self::URL_INVALIDO => "URL incorreta"
    );

    public function isValid($value) {
        if (Zend_Uri::check($value)) {
            $hostnameValidator = new Zend_Validate_Hostname(Zend_Validate_Hostname::ALLOW_ALL); //do not allow local hostnames, this is the default
            $uriHttp = Zend_Uri_Http::fromString($value);
            if ( $hostnameValidator->isValid($uriHttp->getHost()) )
                return true;
        }
        $this->_error(self::URL_INVALIDO);
        return false;
    }

}