<?php

namespace App\Controller;

use App\Entity\Mask;
use App\Form\MaskType;
use App\Repository\MaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mask")
 */
class MaskController extends AbstractController
{
    /**
     * @Route("/", name="mask_index", methods={"GET"})
     */
    public function index(MaskRepository $maskRepository): Response
    {
        return $this->render('admin/mask/index.html.twig', [
            'masks' => $maskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mask_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mask = new Mask();
        $form = $this->createForm(MaskType::class, $mask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mask);
            $entityManager->flush();

            return $this->redirectToRoute('mask_index');
        }

        return $this->render('admin/mask/new.html.twig', [
            'mask' => $mask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mask_show", methods={"GET"})
     */
    public function show(Mask $mask): Response
    {
        return $this->render('admin/mask/show.html.twig', [
            'mask' => $mask,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mask_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mask $mask): Response
    {
        $form = $this->createForm(MaskType::class, $mask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mask_index');
        }

        return $this->render('admin/mask/edit.html.twig', [
            'mask' => $mask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mask_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mask $mask): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mask->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mask_index');
    }
}
