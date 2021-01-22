<?php


namespace Core\Forms;


use BadMethodCallException;

class Form
{

	/**
	 * @var IFormControl[]
	 */
	private array $controls = [];

	/**
	 * @var IFormButton[]
	 */
	private array $buttons = [];

	/**
	 * @var callable
	 */
	private mixed $callback = NULL;


	/**
	 * Form constructor.
	 *
	 * @param string $formName
	 */
	public function __construct(
		private string $formName
	) {
	}


	/**
	 * Add new control to form
	 *
	 * @param IFormControl $control
	 *
	 * @return IFormControl
	 */
	public function addControl(IFormControl $control) : IFormControl
	{
		if (!$control->getName()) {
			throw new BadMethodCallException('Control has no name.');
		}
		if (isset($this->controls[$control->getName()])) {
			throw new BadMethodCallException("Control with same name ({$control->getName()}) already exist.");
		}

		return $this->controls[$control->getName()] = $control;
	}


	/**
	 * Add new button to form
	 *
	 * @param IFormButton $button
	 *
	 * @return IFormButton
	 */
	public function addButton(IFormButton $button) : IFormButton
	{
		if (!$button->getName()) {
			throw new BadMethodCallException('Button has no name.');
		}
		if (isset($this->buttons[$button->getName()])) {
			throw new BadMethodCallException("Button with same name ({$button->getName()}) already exist.");
		}

		return $this->buttons[$button->getName()] = $button;
	}


	/**
	 * Get form buttons
	 *
	 * @return IFormButton[]
	 */
	public function getButtons() : array
	{
		return $this->buttons;
	}


	/**
	 * Render form
	 */
	public function render() : void
	{
		$form = $this;

		require __DIR__ . '/form.phtml';
	}


	/**
	 * @param callable $callback
	 */
	public function setCallback(callable $callback) : void
	{
		$this->callback = $callback;
	}


	/**
	 * @return bool If form was processed
	 */
	public function process() : bool
	{
		if (empty($_POST) || !isset($_POST['_id']) || $_POST['_id'] != $this->formName) {
			return FALSE;
		}

		$valid = TRUE;
		$values = [];

		foreach ($this->getControls() as $control) {
			if (isset($_POST[$control->getName()]) && !empty($_POST[$control->getName()])) {
				$control->setValue(trim($_POST[$control->getName()]));
			}

			if ($control->validate()) {
				$values[$control->getName()] = $_POST[$control->getName()];
			} else {
				$valid = FALSE;
			}
		}

		if ($valid && $this->callback !== NULL) {
			($this->callback)($values);

			return TRUE;
		}

		return FALSE;
	}


	/**
	 * Get form controls
	 *
	 * @return IFormControl[]
	 */
	public function getControls() : array
	{
		return $this->controls;
	}

}
