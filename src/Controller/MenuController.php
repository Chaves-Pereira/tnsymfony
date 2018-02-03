<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Menu;

/**
* 
*/
class MenuController extends Controller
{
	public function menuHeader() {
		$menu = $this->getDoctrine()->getManager()->getRepository(Menu::class)->findByName('header');
		return $this->render('Menu/menu-header.html.twig', array(
			'menu' => $menu,
		));
	}

	public function menuFooter() {
		$menu = $this->getDoctrine()->getManager()->getRepository(Menu::class)->findByName('footer');
		return $this->render('Menu/menu-header.html.twig', array(
			'menu' => $menu,
		));
	}
}