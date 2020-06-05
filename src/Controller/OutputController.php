<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Controller;

use App\Entity\Output;
use App\Form\OutputType;
use App\Repository\OutputRepository;
use App\Repository\ZoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OutputController
 * @package App\Controller
 * @Route("/output")
 */
class OutputController extends AbstractController
{
    /**
     * @Route("/", name="output")
     */
    public function index(OutputRepository $outputRepository)
    {
        return $this->render('admin/output/index.html.twig', [
            'controller_name' => 'OutputController',
            'outputs' => $outputRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="output_new")
     */
    public function new(Request $request, ZoneRepository $zoneRepository)
    {
        $output =  new Output();
        $formOutput = $this->createForm(OutputType::class, $output);
        $formOutput->handleRequest($request);

        if ($formOutput->isSubmitted() && $formOutput->isValid()) {
            $output->setZone($zoneRepository->findOneBy([
                'category' => $request->request->get('phase-select')
            ]));
            $em = $this->getDoctrine()->getManager();
            $em->persist($output);
            $em->flush();

            return $this->redirectToRoute('output');
        }

        return $this->render('admin/output/new.html.twig', [
            'formOutput' => $formOutput->createView(),
        ]);
    }

    /**
     * @Route("/show", name="output_show")
     */
    public function show(Request $request, OutputRepository $outputRepository)
    {
        $output = $request->get('search');
        $output = $outputRepository->findOneById($output);
        return $this->render('admin/output/show.html.twig', [
            'output' => $output,
        ]);
    }
}
