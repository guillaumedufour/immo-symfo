<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * display all ads
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
     * Create an ad
     * @Route("/ads/new",name="ads_create")
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Ad();

        $form = $this->createForm(AnnonceType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on commente car on met directement le manager en params de la fonction
            //$manager = $this->getDoctrine()->getManager();

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',"l'annonce <strong> {$ad->getTitle()}</strong> a bien été enregistrée");

            return $this->redirectToRoute('ads_show', ['slug' => $ad->getSlug()]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * display 1 ad
     * @Route("/ads/{slug}", name="ads_show")
     * @return Response
     */
    public function show(Ad $ad)
    {
        //in params Ad $ad we get ad entity matching with slug thanks to sf dependency injection. we convert {slug} in Ad entity

        //we get the ad with the right slug (we need a $slug param in the show function)
        //$ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig', ['ad' => $ad]);
    }

}
