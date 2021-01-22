<?php


namespace Core\Forms;


class InputText extends FormControl
{

	/**
	 * @var bool Text or textarea
	 */
	private bool $multiline = FALSE;


	/**
	 * Text or textarea
	 *
	 * @param bool $multiline
	 */
	public function setMultiline(bool $multiline) : void
	{
		$this->multiline = $multiline;
	}


	/**
	 * Render text input
	 */
	public function render() : void
	{
		$required = $this->required ? 'required' : '';
		$errors = implode(', ', $this->errors);

		if ($this->multiline) {
			$value = $this->value ? htmlspecialchars($this->value) : '';

			echo <<<EOT
                <label>{$this->label}</label>
                <textarea 
                        name="{$this->name}"
                        rows="5"
                        {$required}
                >{$value}</textarea>
                <span class="error">{$errors}</span>
            EOT;
		} else {
			$value = $this->value ? 'value="' . htmlspecialchars($this->value) . '"' : '';

			echo <<<EOT
                <label>{$this->label}</label>
                <input 
                    type="text"
                    name="{$this->name}"
                    {$value}
                    {$required}
                >
                <span class="error">{$errors}</span>
            EOT;
		}
	}


	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function validate() : bool
	{
		return parent::validate();
	}

}
