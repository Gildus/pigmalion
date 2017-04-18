<?php

/**
 * Class serviceEmployee
 */
class serviceEmployee
{
    private $empleados;

    public function __construct()
    {
        $settings = require __DIR__ . '/../src/settings.php';
        $app = new \Slim\App($settings);
        $service = $app->get('dataEmployees');
        $this->empleados = $service->getData();
    }

    /**
     * Busqueda de Empleados por rango de salarios
     * @param int $min Salario minimo.
     * @param int $max Salario máximo
     * @return array Lista de Empleados
     *
     */
    public function searchBySalary($min, $max){
        $result = [
            'vamos' => 'Perú'
        ];
        /*foreach ($this->empleados as $empleado) {
            $salaryInNumbers = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
            $num = $salaryInNumbers->parseCurrency($empleado->salary, $curr);
            var_dump($num);
            if ($min <= $num && $num <= $max) {
                $result[] = $empleado;
            }
        }
        */
        return $result;
    }
}