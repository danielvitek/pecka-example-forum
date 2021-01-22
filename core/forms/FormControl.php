<?php


namespace Core\Forms;


abstract class FormControl implements IFormControl
{

	/**
	 * @var mixed Value of control
	 */
	protected mixed $value = NULL;

	/**
	 * @var array Array of errors in case the control is invalid
	 */
	protected array $errors = [];


	/**
	 * FormControl constructor.
	 *
	 * @param string $name
	 * @param string $label
	 * @param bool $required
	 */
	public function __construct(
		protected string $name,
		protected string $label = '',
		protected bool $required = FALSE,
	) {
	}


	/**
	 * Return control name
	 *
	 * @return string Control name
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/**
	 * Return control label
	 *
	 * @return string Control label
	 */
	public function getLabel() : string
	{
		return $this->label;
	}


	/**
	 * @return array|NULL
	 */
	public function validate() : bool
	{
		if ($this->isRequired() && empty($this->value)) {
			$this->errors[] = 'Hodnota je povinná';
		}

		return empty($this->errors);
	}


	/**
	 * Return control required
	 *
	 * @return bool Control required
	 */
	public function isRequired() : bool
	{
		return $this->required;
	}


	/**
	 * Return control errors
	 *
	 * @return array Errors
	 */
	public function getErrors() : array
	{
		return $this->errors;
	}


	/**
	 *
	 */
	public function setValue(mixed $value) : void
	{
		$this->value = $value;
	}

}
