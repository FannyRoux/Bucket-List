<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home():Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route('/aboutUs', name:'main_aboutUs')]
    public function aboutUs():Response
    {
        $creatorsInfo= json_decode(file_get_contents($this->getParameter('app.data') . 'team.json'),true);


        return $this->render('main/aboutUs.html.twig',[
            'creators'=>$creatorsInfo
        ]);
    }
}