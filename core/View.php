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

/**
 * Class View
 * @package engine\core
 */
class View
{
    /**
     * @var string
     */
    public $path;
    /**
     * @var
     */
    public $route;
    /**
     * @var string
     */
    public $layout = 'index';

    /**
     * View constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route[0] . '/' . $route[1];
    }

    /**
     * @param $title
     * @param array $vars
     */
    public function render($title, $vars = [])
    {
        extract($vars);
        $renderPath = 'content/views/' . $this->path . '.php';
        if (file_exists($renderPath)) {
            ob_start();
            require $renderPath;
            $content = ob_get_clean();
            require 'content/views/layouts/' . $this->layout . '.php';
        }
    }

    /**
     * @param $url
     */
    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    /**
     * @param $code
     */
    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'content/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    /**
     * Возвращает сообщение (в верхнем правом углу) собщение пользователю
     * @param $status
     * Статус собщения: error, success, warning
     * @param $message
     * Отображаемое собощение
     */
    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    /**
     * @param $url
     */
    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }

    public function reload()
    {
        exit(json_encode(['reload' => 'OK']));
    }

    /**
     * @param array $vars
     */
    public function data(array $vars = [])
    {
        exit(json_encode(['status' => 'OK', 'data' => $vars]));
    }

    /**
     * @param array $vars
     */
    public function json(array $vars = [])
    {
        exit(json_encode($vars));
    }

    /**
     * @param string $vars
     */
    public function raw_json($vars = '{}')
    {
        exit($vars);
    }


}	