<?php
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server as SoapServer;

$container = $app->getContainer();
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

$app->get('/listado', function($request, $response, $args) {
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

$app->post('/listado', function($request, $response) {
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

$app->get("/v1/wsdl", function($request, $response) {
    $url_webservice = $request->getUri()->getBaseUrl().'/v1';
    $autodiscover = new AutoDiscover();
    $autodiscover->setClass(serviceEmployee::class)
        ->setServiceName(serviceEmployee::class)
        ->setUri($url_webservice);
    $response = $response->withHeader('Content-type', 'application/xml');
    $response->write($autodiscover->toXml());

    return $response;
});

$app->post("/v1", function($request, $response) {
    $url_webservice = $request->getUri()->getBaseUrl().'/v1';
    $server = new SoapServer($url_webservice."/wsdl", [
        'uri' => $url_webservice,
        'location' => $url_webservice,
    ]);
    $server->setClass(serviceEmployee::class);

    return $server->handle();
});