<?php

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

global $prices;
$prices = require '.\config\prices.php';

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
        global $prices;

        $types = ['шрот' => true, 'жмых' => true, 'соя' => true,];
        $months = ['январь' => true, 'февраль' => true, 'август' => true, 'сентябрь' => true, 'октябрь' => true, 'ноябрь' => true];
        $tonnages = ['25' => true, '50' => true, '75' => true, '100' => true,];

        //valid1 NotEnoughArguments
        if (!isset($this->type)) {
            $this->printNotEnoughArguments("type");
            return;
        } elseif (!isset($this->tonnage)) {
            $this->printNotEnoughArguments("tonnage");
            return;
        } elseif (!isset($this->month)) {
            $this->printNotEnoughArguments("month");
            return;
        }

        //valid2 NotExists
        if (!array_key_exists($this->type, $types)) {
            $this->printNotExistsError('type', $this->type);
            return;
        } elseif (!array_key_exists($this->tonnage, $tonnages)) {
            $this->printNotExistsError('tonnage', $this->tonnage);
            return;
        } elseif (!array_key_exists($this->month, $months)) {
            $this->printNotExistsError('month', $this->month);
            return;
        }


        echo "Месяц: {$this->month}" . PHP_EOL;
        echo "Тип: {$this->type}" . PHP_EOL;
        echo "Тоннаж: {$this->tonnage}" . PHP_EOL;
        echo "Результат: {$prices[$this->type][$this->tonnage][$this->month]}" . PHP_EOL;

        echo $this->table($this->type);
        die;
    }

    private function printNotExistsError($key, $value)
    {
        $message = $this->ansiFormat('выполнение команды завершено с ошибкой' . PHP_EOL . "не найден прайс для значения --$key=$value", Console::FG_RED);
        echo $message;
    }

    private function printNotEnoughArguments($key)
    {
        $message = $this->ansiFormat("выполнение команды завершено с ошибкой. " . PHP_EOL . "необходимо ввести  --$key" . PHP_EOL, Console::FG_RED);
        echo $message;
    }


    public function table($type)
    {

        $tables = [
            'шрот' =>
                "
                +-----+--------+---------+--------+----------+---------+--------+
                | м/т | январь | февраль | август | сентябрь | октябрь | ноябрь |
                +-----+--------+---------+--------+----------+---------+--------+
                | 25  | 125    | 121     | 137    | 126      | 124     | 128    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 50  | 145    | 118     | 119    | 121      | 122     | 147    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 75  | 136    | 137     | 141    | 137      | 131     | 143    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 100 | 138    | 142     | 117    | 124      | 147     | 112    |
                +-----+--------+---------+--------+----------+---------+--------+",
            'жмых' =>
                "
                +-----+--------+---------+--------+----------+---------+--------+
                | м/т | январь | февраль | август | сентябрь | октябрь | ноябрь |
                +-----+--------+---------+--------+----------+---------+--------+
                | 25  | 121    | 137     | 124    | 137      | 122     | 125    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 50  | 118    | 121     | 145    | 147      | 143     | 145    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 75  | 137    | 124     | 136    | 143      | 112     | 136    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 100 | 142    | 131     | 138    | 112      | 117     | 138    |
                +-----+--------+---------+--------+----------+---------+--------+",
            'соя' =>
                "
                +-----+--------+---------+--------+----------+---------+--------+
                | м/т | январь | февраль | август | сентябрь | октябрь | ноябрь |
                +-----+--------+---------+--------+----------+---------+--------+
                | 25  | 137    | 125     | 124    | 122      | 137     | 121    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 50  | 147    | 145     | 145    | 143      | 119     | 118    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 75  | 112    | 136     | 136    | 112      | 141     | 137    |
                +-----+--------+---------+--------+----------+---------+--------+
                | 100 | 122    | 138     | 138    | 117      | 117     | 142    |
                +-----+--------+---------+--------+----------+---------+--------+",

        ];
        return $tables[$type];
    }

//    private function getTable($type)
//    {
//        $raw = 'шрот';
//        $result = ['| т/м'];
//
//        foreach ($prices[$raw]['25'] as $month => $value) {
//            $result[] = $month;
//        }
//
//        $top = implode(' | ', $result) . " |";
//
//        $between = "";
//
//        for ($i = 0; $i < strlen($top); $i++) {
//            if ($top[$i] === '|') {
//                $between .= '+';
//            } else {
//                $between .= '-';
//            }
//        }
//
//        echo strlen($top);
//        echo strlen($between);
//
//
//    }
}



