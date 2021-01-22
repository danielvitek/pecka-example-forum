<?php


namespace App\Controllers;


use App\Models\ThreadRepository;
use Core\Forms\Button;
use Core\Forms\Form;
use Core\Forms\InputEmail;
use Core\Forms\InputText;
use Core\Presenter;

class Thread extends Presenter
{

	/**
	 * @var ThreadRepository
	 */
	private ThreadRepository $threads;

	/**
	 * @var array|NULL
	 */
	private ?array $currentThread = [];


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
		// Current thread
		$this->currentThread = $this->threads->get($this->requestArgs[0]);
		if (!$this->currentThread) {
			$this->redirect('/index');
		}

		// Form new post
		$this->data->formNewPost = $this->getNewPostForm();
		$this->data->formNewPost->process();
	}


	/**
	 * @return Form
	 */
	private function getNewPostForm() : Form
	{
		$form = new Form('post_form');

		$form->addControl(
			new InputEmail(
				name: 'author',
				label: 'Váš e-mail',
				required: TRUE,
			)
		);

		$form->addControl(
			new InputText(
				name: 'content',
				label: 'Komentář',
				required: TRUE,
			)
		)->setMultiline(TRUE);

		$form->addButton(
			new Button(
				name: 'submit',
				label: 'Přidat',
			)
		);

		$form->setCallback(
			function ($data) {
				$postId = $this->threads->createPost($this->currentThread['id'], $data);

				$this->redirect("/thread/{$this->currentThread['name']}#post--" . $postId);
			}
		);

		return $form;
	}


	/**
	 * @param string $name
	 */
	public function process($name) : void
	{
		$this->data->thread = $this->currentThread;
		$this->data->posts = $this->threads->getThreadPosts($this->currentThread['id']);

		$this->render();
	}

}
