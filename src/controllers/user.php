<?php

// declare (strict_types = 1);

// namespace Nofw\Controllers;

class UserController extends AbstractController
{
    private $config;
    private $model;
    protected $view;

    public function __construct(Config $config, UserModel $model, ViewService $view)
    {
        $this->config = $config;
        $this->model = $model;
        $this->view = $view;
    }
}
