<?php namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller {

	/**
	 * @Route("/")
	 */
	public function home() {
		return $this->render('Main/home.html.twig', [
			'mostSearchedWords' => $this->wordRepository()->findMostSearched(),
			'mostSearchedIncorrectForms' => $this->incorrectFormRepository()->findMostSearched(),
		]);
	}

	/**
	 * @Route("/about")
	 */
	public function about() {
	}

	/**
	 * @Route("/talkoven")
	 */
	public function talkoven() {
	}
	/**
	 * @Route("/sinonimen")
	 */
	public function sinonimen() {
	}
	/**
	 * @Route("/pravopisen")
	 */
	public function pravopisen() {
	}
}
