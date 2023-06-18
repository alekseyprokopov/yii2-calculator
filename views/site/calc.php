<?php

use yii\base\Model;

class CalculationForm extends Model
{
    public $types;
    public $tonnage;
    public $month;
}

$model = new CalculationForm();
$form = ActiveForm::begin([
    'id' => 'form',
    'method' => 'post',

    ])
?>

