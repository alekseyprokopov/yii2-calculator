<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var  app\models\CalculatorForm $model */

/** @var  app\models\PricesRepository $repository */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;


$this->title = 'Калькулятор стоимости доставки сырья';
?>

<?php if (Yii::$app->session->hasFlash('success-login')): ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Здравствуйте, <strong><?= Yii::$app->session->getFlash('success-login') ?></strong>, вы авторизовались в системе
        расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в <a
            href="history/index" class="link-primary">журнале
            расчетов.</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php endif; ?>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center my-5"><?= Html::encode($this->title) ?></h2>
            <div class="col-md-6 col-lg-8">
                <div class="login-wrap p-4 p-md-4 border border-warning rounded">

                    <?php $form = ActiveForm::begin([
                                'id' => 'calculator-form',
                                'enableAjaxValidation' => true,
                                'validationUrl' => Url::toRoute('calculator/calculator-validation'),
                            ]); ?>

                    <div class="row">
                        <div class="col">
                            <?=
                            $form->field($model, 'raw_type')
                                ->dropDownList(
                                    $repository->getRawTypesList(),
                                    ['prompt' => 'Не выбрано'],
                                );
                            ?>
                        </div>

                        <div class="col">
                        <?=
                        $form->field($model, 'tonnage')
                            ->dropDownList(
                                $repository->getTonnagesList(),
                                ['prompt' => 'Не выбрано'],
                            );
                        ?>
                        </div>
                        <div class="col">

                        <?=
                        $form->field($model, 'month')
                            ->dropDownList(
                                $repository->getMonthsList(),
                                ['prompt' => 'Не выбрано']
                            );
                        ?>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <?= Html::submitButton('Рассчитать доставку', ['class' => 'btn btn-warning  btn-block ', 'name' => 'calculator-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="modal-content"></div>





<?php
$js = <<<JS

    $('#calculator-form').on('beforeSubmit', function (){
        var data = $(this).serialize();
        $.ajax({
        url:'/calculator/index',
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

?>




