<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * diplay all ads
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
        // $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * display 1 ad
     * @Route("/ad/{slug}", name="ads_show")
     * @return Response
     */
    public function show($slug, AdRepository $repo)
    {
        //we get the ad with the right slug
        $ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig', ['ad' => $ad]);
    }
}
