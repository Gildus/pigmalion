<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// data json
$container['dataEmployees'] = function($container) {
    return  new class($container) {
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
                if (isset($item->email) && stristr($item->{$field}, $value)) {
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
};
