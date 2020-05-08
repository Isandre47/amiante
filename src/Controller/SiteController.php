<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Site;
use App\Entity\Zone;
use App\Form\CategoryType;
use App\Form\SiteType;
use App\Repository\CategoryRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SiteController
 * @package App\Controller
 * @Route("/site")
 */
class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site_index")
     */
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('admin/site/index.html.twig', [
            'controller_name' => 'SiteController',
            'sites' => $siteRepository->findAll(),
        ]);
    }

    /**
     * @Route("new", name="site_new")
     */
    public function new(Request $request , CategoryRepository $categoryRepository): Response
    {
        $site = new Site();
        $category = new Category();
        $zone = new Zone();
        $formSite = $this->createForm(SiteType::class, $site);
        $formCategory = $this->createForm(CategoryType::class, $category, [
            'action' => '/category/new'
            ]);
        $formSite->handleRequest($request);

        if ($formSite->isSubmitted()) {
            $zone->setSite($site);
            $zoneName = $categoryRepository->find($request->request->get('site')["zones"]);
            $zone->setCategory($zoneName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($site);
            $em->persist($zone);
            $em->flush();

            return $this->redirectToRoute('site_index');
        }

        return $this->render('admin/site/new.html.twig', [
            'formSite' => $formSite->createView(),
            'formCategory' => $formCategory->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="site_edit")
     */
    public function edit(Request $request, Site $site, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $zone = new Zone();
        $formSite = $this->createForm(SiteType::class, $site);
        $formSite->handleRequest($request);

        /*
         * Ajout d'une valeur "origin" afin de pouvoir récuperer cette valeur dans le formulaire d'ajout de catégorie
         * Sa valeur est l'id du site qui sera passé en paramètre de la redirection après ajout du champ
         */
        $formCategory = $this->createForm(CategoryType::class, $category, [
            'action' => '/category/new',
        ])->add('origin', HiddenType::class, [
            'mapped' => false,
            'attr' => ['value' => $site->getId()]
        ]);

        if ($formSite->isSubmitted() && $formSite->isValid()) {
            $zone->setSite($site);
            $zoneName = $categoryRepository->find($request->request->get('site')["zones"]);
            $zone->setCategory($zoneName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($site);
            $em->persist($zone);
            $em->flush();


            return $this->redirectToRoute('site_index');
        }

        return $this->render('admin/site/edit.html.twig',[
            'formSite' => $formSite->createView(),
            'formCategory' => $formCategory->createView(),
            'site' => $site,
        ]);
    }
}
