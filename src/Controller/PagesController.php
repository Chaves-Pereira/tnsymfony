<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Page;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Menu;


class PagesController
{
	/**
	* @Route("/", name="home") 
	*/
	public function index(Environment $twig, RegistryInterface $doctrine) : Response {
		$em = $doctrine->getManager();
		$category = $em->getRepository(Category::class)->findByName('home');
		$pages = $category->getPages();

		return new Response($twig->render('Pages/home.html.twig', compact('pages')));
	}
	/**
	* @Route("/page/{slug}", name="page")
	*/
	public function viewPage(Page $page, $slug, Environment $twig) {
		return new Response($twig->render('Pages/page.html.twig', compact('page')));
	}

}