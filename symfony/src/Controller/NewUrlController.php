<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Url;
use App\Entity\UrlHasHeaders;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

class NewUrlController extends AbstractController
{
    /**
     * @Route("/newurl", name="new_url")
     */
    public function index(Request $request){
        if($request->query->get('url')){
            $jsonData = array();
            try{
                $client = new Client();
                $response = $client->request('GET', $request->query->get('url'), [
                    // Obter o url final
                    'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$url) {
                        $url = $stats->getEffectiveUri();
                    }
                ]);
                // Adicionar url e datetime a tabela url da base de dados
                $em = $this->container->get('doctrine')->getManager();
                $db_url = new Url();
                $db_url->setUrl($url);
                $db_url->setDate(new \DateTime());
                $em->persist($db_url);
                $em->flush();
                $url_id = $db_url->getId(); // Obter o id do tuplo inserido
                // Mostrar todos os headers
                foreach ($response->getHeaders() as $name => $values) {
                    // Adiciona os Headers a tabela url_has_headers da base de dados
                    $em = $this->container->get('doctrine')->getManager();
                    $db_url_has_header = new UrlHasHeaders();
                    $db_url_has_header->setUrlId($url_id);
                    $db_url_has_header->setHeader($name);
                    $db_url_has_header->setValue(implode(', ', $values));
                    $em->persist($db_url_has_header);
                    $em->flush();
                }
                $jsonData[0] = array(
                    'refresh' => 'yes'
                );
            }catch(\Exception $e){
                // Guardar erro de invalido ou inexistente
                $jsonData[0] = array(
                    'error' => 'invalid'
                );
            }
            return new JsonResponse($jsonData);
        }else{
            $jsonData = array();
            $jsonData[0] = array(
                'error' => 'nourl'
            );
            return new JsonResponse($jsonData);
        }
    }
}
