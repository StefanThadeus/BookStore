<?php

namespace BookStore\Application\Presentation\SinglePage\Controllers;

class Controller
{
    public function model($model): void
    {
        // require model file
    }

    // Load the view (checks for the file)
    public function view($view, $data = []): void
    {
        if (file_exists(__DIR__ . "/../../../.." . $view . '.php')) {
            require_once __DIR__ . "/../../../.." . $view . '.php';
        } else {
            die("View does not exist!");
        }
    }
}