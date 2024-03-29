<?php
/*
=====================================================
 NemeaQ-CMS - by NemeaQ
-----------------------------------------------------
 https://hanriel.ru/
-----------------------------------------------------
 Copyright (c) 2021 NemeaQ
=====================================================
*/
namespace engine\core;

defined('_USE_NQ_CMS') or Die('Direct Access to this location is not allowed.');

use engine\core\View;

/**
 * Class Controller
 * @package engine\core
 * @author Hanriel
 */
abstract class Controller
{
    public Model $model;
    public View $view;
    public array $route;
    public array $acl;

    /**
     * Конфигурации сайта
     * @var array|mixed
     */
    public array $config;

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->config = require 'content/config.php';
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route[0]);
    }

    /**
     * @param $name 'Имя модели'
     * @return Model|null
     */
    public function loadModel($name): ?Model
    {
        $path = 'content\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
        return null;
    }

    /**
     * Cписок контроля доступа
     * @return bool
     */
    public function checkAcl(): bool
    {
        return (
            $this->isAcl('all') ||
            isset($_SESSION['account']['id']) && $this->isAcl('authorize') ||
            !isset($_SESSION['account']['id']) && $this->isAcl('guest') ||
            isset($_SESSION['admin']) && $this->isAcl('admin')
        );
    }

    /**
     * Cписок контроля доступа
     * @param $key
     * @return bool
     */
    public function isAcl($key): bool
    {
        return in_array($this->route[1], $this->acl[$key]);
    }

}