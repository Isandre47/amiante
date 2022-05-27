<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\Initial;
use App\Entity\Site;
use App\Entity\Zone;
use App\Form\InitialType;
use App\Repository\InitialRepository;
use App\Repository\ZoneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InitialController
 * @package App\Controller
 * @Route("/admin/initial")
 */
class InitialController extends AbstractController
{
    /**
     * @Route("/", name="initial", methods={"GET"})
     */
    public function index(InitialRepository $initialRepository): Response
    {
        return $this->render('admin/initial/index.html.twig', [
            'controller_name' => 'InitialController',
            'initials' => $initialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="initial_new", methods={"GET","POST"})
     */
    public function new(Request $request, ZoneRepository $zoneRepository, ManagerRegistry $managerRegistry): RedirectResponse|Response
    {
        $initial =  new Initial();
        $formInitial = $this->createForm(InitialType::class, $initial);
        $formInitial->handleRequest($request);

        if ($formInitial->isSubmitted() && $formInitial->isValid()) {
            $initial->setZone($zoneRepository->findOneBy([
                'category' => $request->request->get('phase-select')
            ]));
            $em = $managerRegistry->getManager();
            $em->persist($initial);
            $em->flush();

            return $this->redirectToRoute('initial');
        }

        return $this->render('admin/initial/new.html.twig', [
            'formInitial' => $formInitial->createView(),
        ]);
    }

    /**
     * @Route("/show", name="initial_show", methods={"GET"})
     */
    public function show(Request $request, InitialRepository $initialRepository): Response
    {
        $initial = $request->get('search');
        $initial = $initialRepository->findOneById($initial);
        return $this->render('admin/initial/show.html.twig', [
            'initial' => $initial,
        ]);
    }

    /**
     * @Route("/zonebysiteid/{id}", name="zonebysiteid", methods={"GET"})
     */
    public function zoneBySiteId(Site $site, ManagerRegistry $managerRegistry): Response
    {
        $listPhaseBySite = $managerRegistry->getRepository(Zone::class)->findBy(['site'=> $site->getId()]);

        return $this->render('admin/initial/select.html.twig', ['list' => $listPhaseBySite]);
    }
}
