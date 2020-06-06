<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
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
     * @Route("/", name="zone", methods={"GET"})
     */
    public function index()
    {
        return $this->render('zone/index.html.twig', [
        ]);
    }

    /**
     * @Route("/delete/{id}", name="zone_delete", methods={"DELETE"})
     */
    public function delete()
    {

    }

}
