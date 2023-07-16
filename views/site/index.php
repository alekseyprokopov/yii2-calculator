<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\CalculatorForm $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Калькулятор стоимости доставки сырья';
?>

<div class="site-index">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Пожалуйста, заполните все поля для отправки:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'calculator-form',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute('site/validation'),
            "options" => ['class' => 'col-lg-5',
                'data-pjax' => true
            ],
        ]); ?>

        <?=
        $form->field($model, 'raw_type')
            ->dropDownList(
                $repository->getRawTypesList(),
                ['prompt' => 'Не выбрано'],
            );
        ?>

        <?=
        $form->field($model, 'tonnage')
            ->dropDownList(
                $repository->getTonnagesList(),
                ['prompt' => 'Не выбрано'],
            );
        ?>

        <?=
        $form->field($model, 'month')
            ->dropDownList(
                $repository->getMonthsList(),
                ['prompt' => 'Не выбрано']
            );
        ?>

        <div class="mb-2 d-flex justify-content-between">
            <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-warning mt-2 btn-block',
                'name' => 'calculator-button']) ?>
        </div>

        <?php $form = ActiveForm::end() ?>

        <div id="modal-content">
        </div>


    </div>

</div>


<?php
$js = <<<JS

    $('form').on('beforeSubmit', function (){
        var data = $(this).serialize();
        $.ajax({
        url:'/site/index',
        type: 'POST',
        data: data,
        success: function(response) {
          $('#modal-content').html(response)
          $('#resultModal').modal('show')
        }
        })
        return false;
    })



JS;

$this->registerJs($js);

//?>




