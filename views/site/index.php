<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
?>

<div class="site-index"> 
    <h1 class="calculator-name">Калькулятор расчета стоимости доставки</h1>
    <form class="d-grid g-2 col-6 ">
        <div class="col-md-6 align-self-center">
            <label for="inputMonth" class="form-label">Месяц</label>
            <select class="form-select form-select mb-3 form-month" aria-label=".form-select-lg example">
                <option value="1">Январь</option>
                <option value="2">Февраль</option>
                <option value="3">Август</option>
                <option value="4">Сентябрь</option>
                <option value="5">Октябрь</option>
                <option value="6">Ноябрь</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="inputRaw" class="form-label">Сырье</label>
            <select class="form-select form-select mb-3 form-raw" aria-label=".form-select-lg example">
                <option value="1">Шрот</option>
                <option value="2">Жмых</option>
                <option value="3">Соя</option>
            </select>
        </div>



        <div class="col-md-6">
            <label for="inputWeight" class="form-label">Тоннаж</label>

            <select class="form-select form-select mb-5 form-weight" aria-label=".form-select-lg example">
                <option value="1">25</option>
                <option value="2">50</option>
                <option value="3">75</option>
                <option value="4">100</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-outline-warning mb-3 mt-2 ">Рассчитать</button>
        </div>
    </form>
</div>

