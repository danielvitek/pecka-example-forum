<?php


namespace Core\Forms;


class Button extends FormButton
{
    public function render() : void
    {
        echo <<<EOT
            <button 
                name="{$this->name}"
                type="submit" 
                class="btn btn-lg btn-primary"
            >{$this->label}</button>
        EOT;
    }
}