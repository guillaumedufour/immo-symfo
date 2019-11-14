<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/hello/{prenom}",name="hello")
     * @return Response
     */
    public function hello($prenom = null, $age = 18)
    {
        return $this->render('hello.html.twig',
            ['prenom' => $prenom,
                'age' => $age
            ]);

    }

    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        $prenoms = [
            'guillaume' => 12,
            'jean paul' => 14,
            'frero' => 55
        ];

        return $this->render(
            'home.html.twig',
            [
                'title' => 'bonjour',
                'age' => 14,
                'tableau' => $prenoms
            ]

        );
    }


}