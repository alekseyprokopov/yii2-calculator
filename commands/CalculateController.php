<?php

namespace app\commands;

use app\models\CalculatorForm;
use app\models\PricesRepository;
use yii\console\Controller;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\console\widgets\Table;

class CalculateController extends Controller
{
    public $month;
    public $raw_type;
    public $tonnage;

    public function options($actionID)
    {
        return ['month', 'raw_type', 'tonnage'];
    }

    public function actionIndex()
    {
        $repository = new PricesRepository();
        $model = new CalculatorForm();

        $model->month_id = $repository->getMonthIdByName($this->month);
        $model->raw_type_id = $repository->getRawTypeIdByName($this->raw_type);
        $model->tonnage_id = $repository->getTonnageIdByValue($this->tonnage);;

        if ($model->validate()) {
            echo "Месяц: $this->month" . PHP_EOL
                . "Тип сырья: $this->raw_type" . PHP_EOL
                . "Тоннаж: $this->tonnage" . PHP_EOL
                . "Результат: {$repository->getResultPrice($model->raw_type_id,$model->tonnage_id,$model->month_id)} тыс. руб." . PHP_EOL;
            $this->drawTable($repository, $model->raw_type_id);
            return ExitCode::OK;
        };

        $errorMessage = "выполнение команды завершено с ошибкой. " . PHP_EOL;
        foreach ($model->getErrors() as $property => $msgArray) {
            $errorMessage .= array_reduce($msgArray, fn($prev, $next) => $prev . mb_strtolower($next) . " (--$property)", '') . PHP_EOL;
        }
        $errorMessage .= 'проверьте корректность введенных значений' . PHP_EOL;

        Console::output(Console::ansiFormat($errorMessage, [BaseConsole::FG_RED]));
        return ExitCode::DATAERR;
    }

    private function drawTable(PricesRepository $repository, string $raw_type_id)
    {
        //rows for table
        $rows = [];
        foreach ($repository->getTonnagesList() as $tonnage_id => $tonnage) {
            $row = [$tonnage];
            foreach ($repository->getMonthsList() as $month_id => $month) {
                $row[] = $repository->getResultPrice($raw_type_id, $tonnage_id, $month_id);
            }
            $rows[] = $row;
        }

        $table = new Table();
        $table
            ->setHeaders(['тоннаж/месяц', ...array_values($repository->getMonthsList())])
            ->setRows($rows);
        Console::output(Console::ansiFormat($table->run(), [BaseConsole::FG_RED]));
    }
}



