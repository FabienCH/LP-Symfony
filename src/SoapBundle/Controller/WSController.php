<?php
namespace SoapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SoapBundle\Service\SoapService;
use SoapBundle\Service\HelloService;

class WSController extends Controller
{
    /**
     * @Route("/api")
     * @return Response
     */
    public function indexAction()
    {
        $service = $this->get('soap_service');
        $soapServer = new \SoapServer('articleWS.wsdl');
        $soapServer->setObject($service);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * @Route("/api/randomArticle")
     * @return Response
     */
    public function randomArticleAction()
    {
        $service = $this->get('soap_service');
        $soapServer = new \SoapServer('articleWS.wsdl');
        $soapServer->setObject($service);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * @Route("/api/articlePlusVendus")
     * @return Response
     */
    public function articlePlusVendusAction(SoapService $soapService)
    {
        $soapServer = new \SoapServer('articleWS.wsdl');
        $soapServer->setObject($soapService);
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}