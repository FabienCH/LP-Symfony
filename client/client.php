<?php

$soapclient = new SoapClient('http://localhost:8000/api/api?wsdl',['cache_wsdl' => 0]);

var_dump($soapclient->__getFunctions());
$response = $soapclient->randomArticle();

var_dump($response);