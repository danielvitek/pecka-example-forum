<?php


namespace Core\Forms;


abstract class FormButton implements IFormButton
{

	/**
	 * FormButton constructor.
	 *
	 * @param string $name
	 * @param string $label
	 */
	public function __construct(
		protected string $name,
		protected string $label = '',
	) {
	}


	/**
	 * Return button name
	 *
	 * @return string Button name
	 */
	public function getName() : string
	{
		return $this->name;
	}

}
