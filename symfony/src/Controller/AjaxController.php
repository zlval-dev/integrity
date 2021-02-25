<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UrlHasHeaders;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends AbstractController{
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index(Request $request){
        if($request->query->get('id')){
            $jsonData = array();
            $url_id = $request->query->get('id');
            $url_has_headers_db = $this->getDoctrine()->getRepository(UrlHasHeaders::class);
            $data = $url_has_headers_db->findBy([
                'url_id' => $url_id
            ]);
            $index = 0;
            foreach($data as $info){
                $jsonData[$index++] = array(
                    'header' => $info->getHeader(),
                    'value' => $info->getValue()
                );
            }
            return new JsonResponse($jsonData);
        }else{
            return $this->render('ajax/index.html.twig');
        }
    }
}
