<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("category/new-by-site", name="category_new_by_site")
     */
    public function newBySite(Request $request): Response
    {
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category, [
            'data_class' => Category::class,
        ]);
        $formCategory->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        // Si le formulaire d'ajout de catégorie contient un point d'origine, on le traite
        if ($request->request->get('category')['origin'] == 'site_new') {
            $route = 'site_new';
            $site = [];
            $category->setType(SiteController::PHASE);
        } elseif ($request->request->get('category')['origin'] == 'site_edit') {
            $route = 'site_edit';
            $site = ['id' => $request->request->get('category')['siteId']];
            $category->setType(SiteController::PHASE);
        }
        $em->persist($category);
        $em->flush();

        return $this->redirectToRoute($route, $site);

    }

    /**
     * @Route("new", name="category_new")
     */
    public function new(Request $request)
    {
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/new.html.twig', [
            'formCategory' => $formCategory->createView(),
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name="category_edit")
     */
    public function edit(Request $request, Category $category): Response
    {
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/edit.html.twig',[
            'formCategory' => $formCategory->createView(),
        ]);
    }
}
