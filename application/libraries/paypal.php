<?php

class Paypal { 

    public $API_Endpoint;
    public $PAYPAL_URL;

    public function __construct(){

        if (Config::get('paypal.sandbox_mode') === true) 
        {
            $this->API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
            //$this->PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
            $this->PAYPAL_URL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        }
        else
        {
            $this->API_Endpoint = "https://api-3t.paypal.com/nvp";
            $this->PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
        }

    }

    public function test(){
        echo Config::get('paypal.sandbox.username');
    }

}