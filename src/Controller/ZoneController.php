<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Controller;

use App\Entity\Zone;
use App\Form\ZoneType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zone")
 */
class ZoneController extends AbstractController
{
    /**
     * @Route("/", name="zone")
     */
    public function index()
    {
        return $this->render('zone/index.html.twig', [
            'controller_name' => 'ZoneController',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="zone_delete")
     */
    public function delete()
    {

    }

}
