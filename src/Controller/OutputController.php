<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\Output;
use App\Form\OutputType;
use App\Repository\OutputRepository;
use App\Repository\ZoneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OutputController
 * @package App\Controller
 * @Route("/admin/output")
 */
class OutputController extends AbstractController
{
    /**
     * @Route("/", name="output", methods={"GET"})
     */
    public function index(OutputRepository $outputRepository): Response
    {
        return $this->render('admin/output/index.html.twig', [
            'controller_name' => 'OutputController',
            'outputs' => $outputRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="output_new", methods={"GET","POST"})
     */
    public function new(Request $request, ZoneRepository $zoneRepository, ManagerRegistry $managerRegistry): RedirectResponse|Response
    {
        $output =  new Output();
        $formOutput = $this->createForm(OutputType::class, $output);
        $formOutput->handleRequest($request);

        if ($formOutput->isSubmitted() && $formOutput->isValid()) {
            $output->setZone($zoneRepository->findOneBy([
                'category' => $request->request->get('phase-select')
            ]));
            $em = $managerRegistry->getManager();
            $em->persist($output);
            $em->flush();

            return $this->redirectToRoute('output');
        }

        return $this->render('admin/output/new.html.twig', [
            'formOutput' => $formOutput->createView(),
        ]);
    }

    /**
     * @Route("/show", name="output_show", methods={"GET"})
     */
    public function show(Request $request, OutputRepository $outputRepository): Response
    {
        $output = $request->get('search');
        $output = $outputRepository->findOneById($output);
        return $this->render('admin/output/show.html.twig', [
            'output' => $output,
        ]);
    }
}
