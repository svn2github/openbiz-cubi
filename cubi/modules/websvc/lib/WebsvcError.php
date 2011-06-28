<?php

class WebsvcError
{   
    const OK = 0;
    const INVALID_APIKEY = 601;
    const NOT_AUTH = 602;
    const INVALID_METHOD = 603;
    const INVALID_ARGS = 604;
    const SERVICE_ERROR = 605;
    
    protected static $_errorMessage = 
        array(
            '0'=>'Success',
            '601'=>'Incorrect api key or secret.',
            '602'=>'No permission to access the service.',
            '603'=>'Invalid service method',
            '604'=>'Invalid input service method arguments',
            '605'=>'Service internal error.'
        );
    
    public static function getErrorMessage($errorCode)
    {
        if (isset(self::$_errorMessage[$errorCode]))
            return self::$_errorMessage[$errorCode];
        return '';
    }
}

?>