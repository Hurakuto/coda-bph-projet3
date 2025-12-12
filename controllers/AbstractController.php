<?php

abstract class AbstractController
{
    public function __construct()
    {
        $category_m = new CategoryManager();
        $category_m->checkAndCreateDefaultCategories();
    }

    protected function render(string $template, array $data): void
    {
        require "templates/layout.phtml";
    }

    protected function redirect(string $route): void
    {
        header("Location: $route");
    }
}