<?php
namespace SoapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SoapBundle\Service\SoapService;

class WSController extends AbstractController
{
    /**
     * @Route("/api")
     */
    public function indexAction()
    {
        $soapServer = new \SoapServer('articleWS.wsdl');
        $soapServer->setObject(new SoapService());

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * @Route("/api/randomArticle")
     */
    public function randomArticleAction()
    {
        $service = $this->container->get('soap_service');
        $response = $service->articleRandom();

        return $response;
    }

    /**
     * @Route("/api/top3Article")
     */
    public function top3ArticleAction($max)
    {
        $soapServer = new \SoapServer('articleWS.wsdl');
        $soapServer->setObject(new SoapService());

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}