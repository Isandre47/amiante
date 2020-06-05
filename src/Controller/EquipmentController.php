<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EquipmentController
 * @package App\Controller
 * @Route("/equipment")
 */
class EquipmentController extends AbstractController
{
    /**
     * @Route("/", name="equipment_index"), methods={"GET"})
     */
    public function index(EquipmentRepository $equipmentRepository)
    {
        return $this->render('admin/equipment/index.html.twig', [
            'equipments' => $equipmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="equipment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipment $equipment): Response
    {
        if ($equipment->getSite() != null) {
            $siteOrigin = $equipment->getSite()->getName();
        } else {
            $siteOrigin = "Dépôt";
        }

        $formEquipment = $this->createForm(EquipmentType::class, $equipment);
        $formEquipment->handleRequest($request);

        if ($formEquipment->isSubmitted() && $formEquipment->isValid()) {
            $siteDestination = 'Dépôt';
            if ($request->attributes->get('equipment')->getSite() != null) {
                $siteDestination = $request->attributes->get('equipment')->getSite()->getName();
            }
            if ($siteOrigin != $siteDestination) {
                $newSite = [
                    'date_arrived' => new \DateTime(),
                    'site' => $siteDestination,
                ];
                $new = $equipment->getHistory();
                $new[] = $newSite;
                $equipment->setHistory($new);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipment_index');
        }

        return $this->render('admin/equipment/edit.html.twig',[
            'formEquipment' => $formEquipment->createView(),
        ]);
    }

    /**
     * @Route("/new", name="equipment_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $equipment = new Equipment();
        $formEquipment = $this->createForm(EquipmentType::class, $equipment);
        $formEquipment->handleRequest($request);

        if ($formEquipment->isSubmitted() && $formEquipment->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $newSite = [
                'date_arrived' => new \DateTime(),
                'site' => 'Depôt',
            ];
            $new[] = $newSite;
            $equipment->setHistory($new);
            $em->persist($equipment);
            $em->flush();

            return $this->redirectToRoute('equipment_index');
        }

        return $this->render('admin/equipment/new.html.twig', [
            'formEquipment' => $formEquipment->createView(),
        ]);
    }

    /**
     * @Route("/show", name="equipment_show", methods={"GET"})
     */
    public function show(Request $request, EquipmentRepository $equipmentRepository)
    {
        $equipment = $request->get('search');
        $equipment = $equipmentRepository->findOneById($equipment);
        return $this->render('admin/equipment/show.html.twig', [
            'equipment' => $equipment,
        ]);
    }
}
