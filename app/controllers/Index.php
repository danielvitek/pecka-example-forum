<?php


namespace App\Controllers;


use App\Models\ThreadRepository;
use Core\Forms\Button;
use Core\Forms\Form;
use Core\Forms\InputEmail;
use Core\Forms\InputText;
use Core\Presenter;

class Index extends Presenter
{

	/**
	 * @var ThreadRepository
	 */
	private ThreadRepository $threads;


	/**
	 * Index constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->threads = new ThreadRepository();
	}


	/**
	 * Setup controller
	 */
	public function setup() : void
	{
		$this->data->formNewThread = $this->getNewThreadForm();
		$this->data->formNewThread->process();
	}


	private function getNewThreadForm() : Form
	{
		$form = new Form('thread_form');

		$form->addControl(
			new InputText(
				name: 'title',
				label: 'Název vlákna',
				required: TRUE,
			)
		);

		$form->addControl(
			new InputEmail(
				name: 'author',
				label: 'Váš e-mail',
				required: TRUE,
			)
		);

		$form->addControl(
			new InputText(
				name: 'comment',
				label: 'Komentář',
				required: TRUE,
			)
		)->setMultiline(TRUE);

		$form->addButton(
			new Button(
				name: 'submit',
				label: 'Vytvořit',
			)
		);

		$form->setCallback(
			function ($data) {
				$comment = $data['comment'];
				unset($data['comment']);

				$threadId = $this->threads->createThread($data);
				$this->threads->createPost(
					$threadId,
					[
						'author' => $data['author'],
						'content' => $comment,
					]
				);

				$this->redirect('/');
			}
		);

		return $form;
	}


	/**
	 *
	 */
	public function process() : void
	{
		$this->data->threads = $this->threads->getThreads();

		$this->render();
	}

}
