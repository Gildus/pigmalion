<?php

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/../views', [
        //'cache' => __DIR__.'/../cache'
    ]);

    // Instantiate and add Slim specific extension
    //$basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $basePath = $container['request']->getUri()->getPath();
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};