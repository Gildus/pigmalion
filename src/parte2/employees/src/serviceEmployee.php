<?php

/**
 * Class serviceEmployee
 */
class serviceEmployee
{
    /**
     * @var array
     */
    private $empleados;

    public function __construct()
    {
        $settings = require __DIR__ . '/settings.php';
        $app = new \Slim\App($settings);
        $data = file_get_contents($app->getContainer()->get('data_employees'));
        $this->empleados = json_decode($data);
    }

    /**
     * Busqueda de Empleados por rango de salarios
     * @param int $min Salario minimo.
     * @param int $max Salario máximo
     * @return array
     */
    public function searchBySalary($min, $max){
        $result = [];
        if ($min <= $max) {
            foreach ($this->empleados as $empleado) {
                $salaryInNumbers = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
                $num = $salaryInNumbers->parseCurrency($empleado->salary, $curr);
                if ($min <= $num && $num <= $max) {
                    $result[] = $empleado;
                }
            }
        }

        return $result;
    }
}