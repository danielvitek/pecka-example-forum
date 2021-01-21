<?php


namespace Core\Forms;


class InputEmail extends FormControl
{
    /**
     * Render text input
     */
    public function render() : void
    {
        $required = $this->required ? 'required' : '';
        $value = $this->value ? 'value="' . htmlspecialchars($this->value) . '"' : '';
        $errors = implode(', ', $this->errors);

        echo <<<EOT
                <label>
                    {$this->label}
                </label>
                <input 
                    type="email"
                    name="{$this->name}"
                    {$value}
                    {$required}
                >
                <span class="error">{$errors}</span>
            EOT;
    }

    public function validate(): bool
    {
        parent::validate();

        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Hodnota není e-mail';
        }

        return empty($this->errors);
    }
}