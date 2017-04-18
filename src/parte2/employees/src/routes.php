<?php

// Register with container
$container = $app->getContainer();
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

function searchEmployees($data, $needed)
{
    $result = [];
    foreach ($data as $item) {
        if (isset($item->email) && $item->email == $needed) {
            $result[] = $item;
        }
    }

    return $result;
}

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

$app->get('/listado', function($request, $response, $args) use($app) {

    $services = $app->getContainer();
    $data = $str = file_get_contents($services->get('data_employees'));
    $empleados = json_decode($data);

    $nameKey = $this->csrf->getTokenNameKey();
    $valueKey = $this->csrf->getTokenValueKey();
    $name = $request->getAttribute($nameKey);
    $value = $request->getAttribute($valueKey);

    return $this->renderer->render($response, 'listado.phtml', [
        'empleados' => $empleados,
        'csrfToken' => [
            $nameKey => $name,
            $valueKey => $value
        ],

    ]);
})->add($container->get('csrf'))->setName('listado-empleados');

$app->post('/listado', function($request, $response, $args) use($app) {

    $services = $app->getContainer();
    $data = $str = file_get_contents($services->get('data_employees'));
    $dataComplete = json_decode($data);

    $email = $request->getParam('email');
    $empleados = searchEmployees($dataComplete, $email);

    return $this->renderer->render($response, 'listado.phtml', [
        'empleados' => $empleados,
        'returnList' => true,
    ]);
})->add($container->get('csrf'))->setName('listado-empleados-post');

$app->get('/ver/empleado', function ($request, $response, $args) {
    die('Vamos');
})->setName('ver-empleado');
