<?php
namespace SoapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SoapBundle\SoapService;
use Zend\Soap\AutoDiscover;

class WSGenController extends AbstractController {
    /**
     * @Route("api/WSGen")
     */
    public function WSGenAction() {
        $autodiscover = new AutoDiscover();
        $autodiscover->setClass('SoapBundle\Service\SoapService')
            ->setUri('http://localhost:8000/artcileWS');
        header('Content-type: application/wsdl+xml');
        $wsdl = $autodiscover->generate();
        $wsdl->dump("articleWS.wsdl");
        return new Response($wsdl->toXML());
    }
}