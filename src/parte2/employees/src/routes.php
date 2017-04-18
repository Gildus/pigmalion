<?php

// Register with container
$container = $app->getContainer();
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
$container['dataEmployees'] = function($container) {
    $newObject =  new class($container) {
        protected  $container;
        public function __construct($container)
        {
            $this->container = $container;
        }

        public function findFromJson($field, $value)
        {
            $dataComplete = $this->getData();
            $result = [];
            foreach ($dataComplete as $item) {
                if (isset($item->email) && $item->{$field} == $value) {
                    $result[] = $item;
                }
            }

            return $result;
        }

        public function getData()
        {
            $data = $str = file_get_contents($this->container->get('data_employees'));
            $dataComplete = json_decode($data);
            return $dataComplete;
        }
    };


    return $newObject;
};

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

$app->get('/listado', function($request, $response, $args) use($app) {

    $services = $this->get('dataEmployees');
    $empleados = $services->getData();

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

$app->post('/listado', function($request, $response) use($app) {

    $email = $request->getParam('email');
    $services = $this->get('dataEmployees');
    $empleados = $services->findFromJson('email', $email);

    return $this->renderer->render($response, 'listado.phtml', [
        'empleados' => $empleados,
        'returnList' => true,
    ]);
})->add($container->get('csrf'))->setName('listado-empleados-post');

$app->post('/empleado/ver/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $services = $this->get('dataEmployees');
    $empleado = $services->findFromJson('id', $id);

    return $response->withJson($empleado ? $empleado[0] : []);
})->setName('ver-empleado');
