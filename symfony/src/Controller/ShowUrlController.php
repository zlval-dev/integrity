<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Url;

class ShowUrlController extends AbstractController
{
    /**
     * @Route("/", name="show_url")
     */
    public function index(){
        $url_db = $this->getDoctrine()->getRepository(Url::class);
        $data = $url_db->findAll();

        return $this->render('show_url/index.html.twig', [
            'data' => $data,
        ]);
    }
}
