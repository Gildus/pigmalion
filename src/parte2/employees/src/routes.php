<?php

// Register with container
$container = $app->getContainer();
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

function searchEmployees($data, $need)
{

}

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

$app->get('/listado', function($request, $response) use($app) {
    $services = $app->getContainer();
    $data = $str = file_get_contents($services->get('data_employees'));
    $empleados = json_decode($data);

    $nameKey = $this->csrf->getTokenNameKey();
    $valueKey = $this->csrf->getTokenValueKey();
    $name = $request->getAttribute($nameKey);
    $value = $request->getAttribute($valueKey);

    $tokenArray = [
        $nameKey => $name,
        $valueKey => $value
    ];

    return $this->renderer->render($response, 'listado.phtml', [
        'empleados' => $empleados,
        'csrfToken' => $tokenArray,

    ]);
})->add($container->get('csrf'))->setName('listado-empleados');

$app->post('/listado', function($request, $response) use($app) {
    $services = $app->getContainer();
    $data = $str = file_get_contents($services->get('data_employees'));
    $empleados = json_decode($data);

    $email = $request->getParam('email');
    $ok = $app->v::string()->notEmpty()->validate($email);
    var_dump($ok); exit;
    searchEmployees($email);


    return $this->renderer->render($response, 'listado.phtml', [
        'empleados' => $empleados
    ]);
})->add($container->get('csrf'))->setName('listado-empleados');



$app->get('/ver/empleado', function ($request, $response, $args) {
    die('Vamos');
})->setName('ver-empleado');
