<?php

namespace App\Controller;

use App\Entity\Initial;
use App\Form\InitialType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InitialController
 * @package App\Controller
 * @Route("/initial")
 */
class InitialController extends AbstractController
{
    /**
     * @Route("/", name="initial")
     */
    public function index()
    {
        return $this->render('admin/initial/index.html.twig', [
            'controller_name' => 'InitialController',
        ]);
    }

    /**
     * @Route("/new", name="initial_new")
     */
    public function new(Request $request)
    {
        $initial =  new Initial();
        $formInitial = $this->createForm(InitialType::class);

        return $this->render('admin/initial/edit.html.twig', [
            'formInitial' => $formInitial->createView(),
        ]);
    }
}
