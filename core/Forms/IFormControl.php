<?php


namespace Core\Forms;


interface IFormControl
{
    /**
     * Get control name
     * @return string
     */
    public function getName(): string;

    /**
     * Get control label
     * @return string
     */
    public function getLabel(): string;

    /**
     * Is control required to fill?
     * @return bool
     */
    public function isRequired(): bool;


    /**
     * @param mixed $value
     */
    public function setValue(mixed $value): void;

    /**
     * Validate control value
     */
    public function validate(): bool;

    /**
     * Get errors in case control is invalid
     * @return array
     */
    public function getErrors(): array;

    /**
     * Render control
     */
    public function render(): void;
}