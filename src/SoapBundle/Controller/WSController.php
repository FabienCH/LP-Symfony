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
     * @return Response
     */
    public function indexAction()
    {
        $soapServer = new \SoapServer('articleWS.wsdl');
        $soapServer->setObject($this->container->get('soap_service'));

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * @Route("/api/randomArticle")
     * @return mi06\VitrineBundle\Entity\Article
     */
    public function randomArticleAction()
    {
        $service = $this->container->get('soap_service');
        $response = $service->articleRandom();

        return $response;
    }

    /**
     * @Route("/api/top3Article")
     * @param int
     * @return array Top 3 articles
     */
    public function top3ArticleAction($max)
    {
        $service = $this->container->get('soap_service');
        $response = $service->articlePlusVendus($max);

        return $response;
    }
}