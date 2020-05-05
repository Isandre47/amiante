<?php

namespace App\Controller;

use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
