<?php namespace App\Controller;

use App\Entity\IncorrectForm;
use App\Entity\Word;
use App\Repository\IncorrectFormRepository;
use App\Repository\WordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController {

	protected function incorrectFormRepository(): IncorrectFormRepository {
		return $this->getDoctrine()->getRepository(IncorrectForm::class);
	}
	protected function wordRepository(): WordRepository {
		return $this->getDoctrine()->getRepository(Word::class);
	}
}
