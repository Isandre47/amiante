<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 08/06/2020 02:25
 *
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/index", name="category_index", methods={"GET"}))
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="category_new")
     */
    public function new(Request $request, ManagerRegistry $managerRegistry): RedirectResponse|JsonResponse|Response
    {
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            $name = $request->request->get('name');
            $type = $request->request->get('type');
            $category->setName($name);
            $category->settype($type);
            $em = $managerRegistry->getManager();
            $em->persist($category);
            $em->flush();

            return new JsonResponse(['name' => $name, 'type' => $type], 200);
        }

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/new.html.twig', [
            'formCategory' => $formCategory->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category, ManagerRegistry $managerRegistry): Response
    {
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $managerRegistry->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/edit.html.twig',[
            'formCategory' => $formCategory->createView(),
        ]);
    }
}
