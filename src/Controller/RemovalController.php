<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\Removal;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use App\Repository\ZoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RemovalController
 * @package App\Controller
 * @Route("/removal")
 */
class RemovalController extends AbstractController
{
    /**
     * @Route("/", name="removal", methods={"GET"})
     */
    public function index(RemovalRepository $removalRepository)
    {
        return $this->render('admin/removal/index.html.twig', [
            'controller_name' => 'RemovalController',
            'removals' => $removalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="removal_new", methods={"GET","POST"})
     */
    public function new(Request $request, ZoneRepository $zoneRepository)
    {
        $removal =  new Removal();
        $formRemoval = $this->createForm(RemovalType::class, $removal);
        $formRemoval->handleRequest($request);

        if ($formRemoval->isSubmitted() && $formRemoval->isValid()) {
            $removal->setZone($zoneRepository->findOneBy([
                'category' => $request->request->get('phase-select')
            ]));
            $em = $this->getDoctrine()->getManager();
            $em->persist($removal);
            $em->flush();

            return $this->redirectToRoute('removal');
        }

        return $this->render('admin/removal/new.html.twig', [
            'formRemoval' => $formRemoval->createView(),
        ]);
    }

    /**
     * @Route("/show", name="removal_show", methods={"GET"})
     */
    public function show(Request $request, RemovalRepository $removalRepository)
    {
        $removal = $removalRepository->findOneById($request->get('search'));
        return $this->render('admin/removal/show.html.twig', [
            'removal' => $removal,
        ]);
    }
}
