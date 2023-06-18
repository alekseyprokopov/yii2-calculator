<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

class ApiController extends Controller
{

    public function actionCalculatePrice()
    {
        $prices = require '../config/prices.php';

        $month = $_GET['month'];
        $type = $_GET['raw_type'];
        $tonnage = $_GET['tonnage'];
        $price = $prices[$type][$tonnage][$month];

        $result = ['price' => $price, 'price_list' => [$type => $prices[$type]]];
        return json_encode($result, JSON_UNESCAPED_UNICODE);

    }
}
