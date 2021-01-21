<?php

namespace Core;

abstract class Repository
{
    /**
     * @var Database
     */
    protected Database $database;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }
}