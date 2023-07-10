<?php

namespace app\commands;

use app\models\CalculatorForm;
use app\models\PricesRepository;
use yii\console\Controller;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\console\widgets\Table;
use Yii;

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
        $repository = new PricesRepository(Yii::$app->params['prices']);
        $model = new CalculatorForm($this->raw_type, $this->month, $this->tonnage);

        if ($model->validate()) {
            echo "Месяц: $this->month" . PHP_EOL
                . "Тип сырья: $this->raw_type" . PHP_EOL
                . "Тоннаж: $this->tonnage" . PHP_EOL
                . "Результат: {$repository->getResultPrice($this->raw_type,$this->tonnage,$this->month)} тыс. руб." . PHP_EOL;
            $this->drawTable($repository, $this->raw_type);
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

    private function drawTable(PricesRepository $repository, string $raw_type)
    {
        //rows for table
        $rows = [];
        foreach ($repository->getTonnagesList() as $tonnage) {
            $row = [$tonnage];
            foreach ($repository->getMonthsList() as $month) {
                $row[] = $repository->getResultPrice($raw_type, $tonnage, $month);
            }
            $rows[] = $row;
        }

        $table = new Table();
        $table
            ->setHeaders(['тоннаж/месяц', ...array_keys($repository->getMonthsList())])
            ->setRows($rows);
        Console::output(Console::ansiFormat($table->run(), [BaseConsole::FG_RED]));
    }
}



