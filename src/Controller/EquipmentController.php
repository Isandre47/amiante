<?php

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
     * @Route("/", name="equipment_index")
     */
    public function index(EquipmentRepository $equipmentRepository)
    {
        return $this->render('admin/equipment/index.html.twig', [
            'controller_name' => 'EquipmentController',
            'equipments' => $equipmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="equipment_edit")
     */
    public function edit(Request $request, Equipment $equipment): Response
    {
        $formEquipment = $this->createForm(EquipmentType::class, $equipment);
        $formEquipment->handleRequest($request);

        if ($formEquipment->isSubmitted() && $formEquipment->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipment_index');
        }

        return $this->render('admin/equipment/edit.html.twig',[
            'formEquipment' => $formEquipment->createView(),
        ]);
    }
}
