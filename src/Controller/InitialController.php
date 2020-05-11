<?php

namespace App\Controller;

use App\Entity\Initial;
use App\Entity\Site;
use App\Entity\Zone;
use App\Form\InitialType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InitialController
 * @package App\Controller
 * @Route("/initial")
 */
class InitialController extends AbstractController
{
    /**
     * @Route("/", name="initial")
     */
    public function index()
    {
        return $this->render('admin/initial/index.html.twig', [
            'controller_name' => 'InitialController',
        ]);
    }

    /**
     * @Route("/new", name="initial_new")
     */
    public function new(Request $request)
    {
        $initial =  new Initial();
        $formInitial = $this->createForm(InitialType::class, $initial);
        $formInitial->handleRequest($request);

        if ($formInitial->isSubmitted() && $formInitial->isValid()) {
            dd($request, $initial);
            $em = $this->getDoctrine()->getManager();
            $em->persist($initial);
            $em->flush();

            return $this->redirectToRoute('equipment_index');
        }

        return $this->render('admin/initial/new.html.twig', [
            'formInitial' => $formInitial->createView(),
        ]);
    }

    /**
     * @Route("/zonebysiteid/{id}", name="zonebysiteid")
     */
    public function zoneBySiteId(Site $site)
    {
        $listphasebysite = $this->getDoctrine()->getRepository(Zone::class)->findBy(['site'=> $site->getId()]);

        return $this->render('admin/initial/select.html.twig', ['list' => $listphasebysite]);
    }
}
