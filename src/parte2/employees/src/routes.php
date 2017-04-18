<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

$app->get('/listado', function($request, $response) use($app) {

    $services = $app->getContainer();
    $data = $str = file_get_contents($services->get('data_employees'));
    $empleados = json_decode($data);



    return $this->renderer->render($response, 'listado.phtml', [
        'empleados' => $empleados
    ]);

})->setName('listado-empleados');


$app->get('/ver/empleado', function ($request, $response, $args) {
    die('Vamos');
})->setName('ver-empleado');
