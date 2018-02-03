<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Page;

/**
* 
*/
class ApiController extends Controller
{
	
	/**
	* @Route("/api/last", name="apiLast")
	*/
	public function lastPage() {
		$lastPages = $this->getDoctrine()->getManager()->getRepository(Page::class)->findLast();

		$data = $this->get('serializer')->serialize($lastPages, 'json');

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}
}