<?php


namespace Core\Forms;


interface IFormButton
{

	/**
	 * Get button name
	 *
	 * @return string
	 */
	public function getName() : string;


	/**
	 * Render button
	 */
	public function render() : void;

}
