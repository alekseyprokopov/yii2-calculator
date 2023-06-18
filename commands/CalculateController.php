<?php

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;
use app\models\CalculatorForm;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;

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
        
        if($this->validate() === false ) {

            return ExitCode::DATAERR;
        }

        $prices = require(\Yii::getAlias('@app/config/prices.php'));

        // dd($prices[$this->type][$this->tonnage][$this->month]);

        if($this->validatePrice($prices) === false ) {

            return ExitCode::DATAERR;
        }


        $model = new CalculatorForm();


        echo "Месяц: {$this->month}" . PHP_EOL;
        echo "Тип: {$this->type}" . PHP_EOL;
        echo "Тоннаж: {$this->tonnage}" . PHP_EOL;
        echo "Результат: {$prices[$this->type][$this->tonnage][$this->month]}" . PHP_EOL;

        echo $this->drawTable($prices);
        die;
    }


    private function validate(): bool
    {
        if (
            empty($this->type) === true || 
            empty($this->tonnage) === true ||
            empty($this->month) === true 
        ) {
            Console::output(Console::ansiFormat("выполнение команды завершено с ошибкой. " . PHP_EOL . "недостаточно аргументов" . PHP_EOL, [BaseConsole::FG_RED]));
            return false;
        }


        

        return true;

    }

    private function validatePrice($prices): bool
    {
        $errorMessage = [];

        if (isset($prices[$this->type]) === false) 
        {
            $errorMessage[] = 'не найден прайс для значения: ' . $this->type ;
        }

        if (isset($prices[$this->type][$this->tonnage]) === false) 
        {
            $errorMessage[] = 'не найден прайс для значения: ' . $this->tonnage ;
        }

        if (isset($prices[$this->type][$this->tonnage][$this->month]) === false) 
        {
            $errorMessage[] = 'не найден прайс для значения: ' . $this->month ;
        }

        if(count($errorMessage) !== 0) {



            Console::output(Console::ansiFormat("выполнение команды завершено с ошибкой. " . PHP_EOL . 
            implode(PHP_EOL,$errorMessage) . PHP_EOL .
            "проверьте корректность значений" . PHP_EOL, [BaseConsole::FG_RED]));


            return false;
        }

        
        

        return true;

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

   private function drawTable($prices)
   {
    $months = array_keys($prices[$this->type][$this->tonnage]);
    $tonnages = array_keys($prices[$this->type]);


    $between = '+----------------+' . str_repeat('------------+', count($months)) . PHP_EOL;

    $table = $between . '| Месяц / Тоннаж |';

    foreach($months as $month){
        $table .= ' ' . str_pad(substr($month, 0,12), 16, ' ', STR_PAD_BOTH) . ' |';
    }


    $table .= PHP_EOL;
    $table .= $between;

    foreach($tonnages as $tonnage){
        $table .= '| ' . str_pad($tonnage, 14, ' ') . ' |';

        foreach($months as $month){
            $value = $prices[$this->type][$tonnage][$month];
            $table .= ' ' . str_pad($value, 10, ' ', STR_PAD_BOTH) . ' |';
        }
        $table .= PHP_EOL;
    }
    $table .= $between;



    Console::output(Console::ansiFormat($table), [BaseConsole::FG_RED]);
    // dd($table);
    // $tonnages 

    // return $months
   }
}



