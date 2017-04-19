<?php
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server as SoapServer;

$container = $app->getContainer();
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.phtml');
})->setName('home');

$app->get('/listado', function($request, $response, $args) {
    $services = $this->get('dataEmployees');
    $empleados = $services->getData();

    $nameKey = $this->csrf->getTokenNameKey();
    $valueKey = $this->csrf->getTokenValueKey();
    $name = $request->getAttribute($nameKey);
    $value = $request->getAttribute($valueKey);

    return $this->view->render($response, 'listado.phtml', [
        'empleados' => $empleados,
        'csrfToken' => [
            $nameKey => $name,
            $valueKey => $value
        ],

    ]);
})->setName('listado-empleados-get')->add($container->get('csrf'));

$app->post('/listado', function($request, $response) {
    $email = $request->getParam('email');
    if ($email && strlen($email) >= 3) {
        $services = $this->get('dataEmployees');
        $empleados = $services->findFromJson('email', $email);

        return $this->view->render($response, 'listado.phtml', [
            'empleados' => $empleados,
            'returnList' => true,
        ]);
    }

    return $response->withRedirect('/listado');

})->setName('listado-empleados-post')->add($container->get('csrf'));

$app->post('/empleado/ver/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $services = $this->get('dataEmployees');
    $empleado = $services->findFromJson('id', $id);

    return $response->withJson($empleado ? $empleado[0] : []);
})->setName('ver-detalles-empleado');

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