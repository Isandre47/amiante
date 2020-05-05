<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentController extends AbstractController
{
    /**
     * @Route("/equipment", name="equipment")
     */
    public function index()
    {
        return $this->render('equipment/index.html.twig', [
            'controller_name' => 'EquipmentController',
        ]);
    }
}
