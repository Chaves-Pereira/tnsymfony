<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Page;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Menu;
use App\Entity\Link;
use App\Form\PageType;
use App\Form\CategoryType;
use App\Form\ImageType;
use App\Form\MenuType;
use App\Form\LinkType;

class AdminController extends Controller
{
	/**
	* @Route("/admin", name="admin")
	*/
	public function index() {
		
		return  $this->render('Admin/index.html.twig');
	}

	/**
	* @Route("/admin/pages", name="viewPages")
	*/
	public function pages() {
		$pages = $this->getDoctrine()->getManager()->getRepository(Page::class)->findAll();
		return $this->render('Admin/pages.html.twig', array(
			'pages' => $pages,
		));
	}

	/**
	* @Route("/admin/page/add", name="addPage")
	*/
	public function addPage(Request $request) {
		$page = new Page();
		$form = $this->get('form.factory')->create(PageType::class, $page);
		$em = $this->getDoctrine()->getManager();
		$images = $em->getRepository(Image::class)->findAll();

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$page->setAuthor($this->getUser());
			$page->setDateCreate(new \DateTime());

			if ($request->request->get('image')) {
				$page->setImage($em->getRepository(Image::class)->find($request->request->get('image')));
			}

			$em->persist($page);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Page ajoutée');
			return $this->redirectToRoute('admin');
		}

		return  $this->render('Admin/form-page.html.twig', array(
			'form' => $form->createView(),
			'images' => $images,
		));
	}

	/**
	* @Route("/admin/page/edit/{id}", name="editPage")
	*/
	public function editPage(Request $request, Page $page, $id) {
		$em = $this->getDoctrine()->getManager();
		$form = $this->get('form.factory')->create(PageType::class, $page);
		$images = $em->getRepository(Image::class)->findAll();
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			
			$em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Page modifiée.');

			return $this->redirectToRoute('admin');
		}

		return $this->render('Admin/form-page.html.twig', array(
			'form' => $form->createView(),
			'images' => $images,
		));
	}

	/**
	* @Route("/admin/page/delete/{id}", name="deletePage")
	*/
	public function deletePage(Request $request, Page $page, $id) {
		$this->delete($page);
		$request->getSession()->getFlashBag()->add('notice', 'Page supprimée.');

		return $this->redirectToRoute('admin/pages');
	}

	/**
	* @Route("/admin/categories", name="viewCategories")
	*/
	public function categories() {
		$categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
		return $this->render('Admin/categories.html.twig', array(
			'categories' => $categories,
		));
	}

	/**
	* @Route("/admin/category/add", name="addCategory")
	*/
	public function addCategory(Request $request) {
		
		$category = new Category();
		$form = $this->get('form.factory')->create(CategoryType::class, $category);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($category);
			$em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Catégorie modifiée');
			return $this->redirectToRoute('admin');
		}

		return $this->render('Admin/add-category.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	* @Route("/admin/category/edit/{id}", name="editCategory")
	*/
	public function editCategory(Request $request, Category $category, $id) {
		
		$form = $this->get('form.factory')->create(CategoryType::class, $category);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Catégorie modifiée');
			return $this->redirectToRoute('admin');
		}

		return $this->render('Admin/edit-category.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	* @Route("/admin/category/delete/{id}", name="deleteCategory")
	*/
	public function deleteCategory(Category $category, $id) {
		$this->delete($category);
		$request->getSession()->getFlashBag()->add('notice', 'Catégorie supprimée.');

		return $this->redirectToRoute('admin');
	}

	/**
	* @Route("/admin/image/add", name="addImage")
	*/
	public function addImage(Request $request) {
		$image = new Image();
		$form = $this->get('form.factory')->create(ImageType::class, $image);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($image);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Image ajoutée');

			return $this->redirectToRoute('admin');
		}

		return $this->render('Admin/add-image.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	* @Route("/admin/image/edit/{id}", name="editImage")
	*/
	public function editImage(Request $request, Image $image, $id) {

		return $this->redirectToRoute('admin');
	}

	/**
	* @Route("/admin/image/delete/{id}", name="deleteImage")
	*/
	public function deleteImage(Request $request, Image $image, $id) {
		$this->delete($image);
		$request->getSession()->getFlashBag()->add('notice', 'Image supprimée');

		return $this->redirectToRoute('admin');
	}

	/**
	* @Route("/admin/images", name="imagesView")
	*/
	public function imagesView() {
		$images = $this->getDoctrine()->getManager()->getRepository(Image::class)->findAll();

		return $this->render('Admin/images.html.twig', array(
			'images' => $images,
		));
	}

	/**
	* @Route("/admin/menu/add", name="addMenu")
	*/
	public function addMenu(Request $request) {
		$menu = new Menu();
		$form = $this->get('form.factory')->create(MenuType::class, $menu);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($menu);
			$em ->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Menu ajouté.');

			return $this->redirectToRoute('admin');
		}

		return $this->render('Admin/add-menu.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	* @Route("/admin/menu/edit/{id}", name="editMenu")
	*/
	public function editMenu(Request $request, Menu $menu, $id) {
		$link = new Link();
		$form = $this->get('form.factory')->create(LinkType::class, $link);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$menu->addLink($link);

			$em = $this->getDoctrine()->getManager();
			$em->persist($link);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Menu modifié.');

			return $this->redirectToRoute('admin');
		}	

		return $this->render('Admin/edit-menu.html.twig', array(
			'form' => $form->createView(),
			'menu' => $menu,
		));	
	}

	/**
	* @Route("/admin/menu/delete/{id}", name="deleteMenu")
	*/
	public function deleteMenu(Request $request, Menu $menu, $id) {
		$this->delete($menu);
		$request->getSession()->getFlashBag()->add('notice', 'Menu supprimé.');

		return $this->redirectToRoute('admin');
	}

	/**
	* @Route("/admin/menu", name="viewMenus")
	*/
	public function viewMenu() {
		$menus = $this->getDoctrine()->getManager()->getRepository(Menu::class)->findAll();
		return $this->render('Admin/menus.html.twig', array(
			'menus' => $menus,
		));
	}

	public function delete($entity, Request $request) {
		$em = $this->getDoctrine()->getManager();
		$em->remove($entity);
		$em->flush();
	}
}