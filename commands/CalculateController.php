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
    public $type;
    public $tonnage;

    public function options($actionID)
    {
        return ['month', 'type', 'tonnage'];
    }

    public function actionIndex()
    {
        $repository = new PricesRepository(Yii::$app->params['prices']);
        $model = new CalculatorForm($this->type, $this->month, $this->tonnage);

        if ($model->validate()) {
            echo "Месяц: $this->month" . PHP_EOL
                . "Тип сырья: $this->type" . PHP_EOL
                . "Тоннаж: $this->tonnage" . PHP_EOL
                . "Результат: {$repository->getResultPrice($this->type,$this->tonnage,$this->month)} тыс. руб." . PHP_EOL;
            $this->drawTable($repository, $this->type);
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

    private function drawTable(PricesRepository $repository, string $type)
    {
        $table = new Table();
        $table
            ->setHeaders(['тоннаж/месяц', ...array_keys($repository->getMonthsList())])
            ->setRows(
                array_map(function ($tonnage, $month) {
                    return [$tonnage, ...array_values($month)];
                },
                    array_keys($repository->getRawPricesByType($type)), //tonnage
                    $repository->getRawPricesByType($type)) //month => price
            )
            ->setChars([
                'top' => '-',
                'top-mid' => '+',
                'top-left' => '+',
                'top-right' => '+',
                'bottom' => '-',
                'bottom-mid' => '+',
                'bottom-left' => '+',
                'bottom-right' => '+',
                'left' => '|',
                'left-mid' => '+',
                'mid' => '-',
                'mid-mid' => '-',
                'right' => '|',
                'right-mid' => '+',
                'middle' => '|',
            ]);

        Console::output(Console::ansiFormat($table->run(), [BaseConsole::FG_RED]));
    }
}



