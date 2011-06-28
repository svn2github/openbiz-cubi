<?php
include_once 'WebsvcError.php';
include_once 'Array2Xml.php';

class WebsvcResponse
{   
    protected $response = array('error'=>null, 'data'=>null);
    
    public function setError($errorCode, $errorMsg)
    {
        $this->response['error']['code'] = $errorCode;
        $this->response['error']['message'] = $errorMsg;
    }
    
    public function setData($data)
    {
        $this->response['data'] = $data;
    }
    
    public function output($format)
    {
        if ($format == 'xml')
            return $this->printXml();
        elseif ($format == 'json')
            return $this->printJson();
        print_r($this->response);
    }

    protected function printXml()
    {
        header ("Content-Type:text/xml; charset=utf-8"); 
        $xml = new array2xml('response');
        $xml->createNode($this->response);
        echo $xml;
    }
    
    protected function printJson()
    {
        header("Content-type: application/json; charset=utf-8");
        //print json_encode($this->response);
        $x = json_encode($this->response);
        $y = json_decode($x);
        print_r($x);
    }
    
}

?>