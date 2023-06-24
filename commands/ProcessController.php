<?php

namespace app\commands;

use yii\console\Controller;


class ProcessController extends Controller
{

    public function actionQueueResults()
    {
        $basePath = '.\runtime\queue.job';
        $counter = 0;
        echo $basePath;

        while (true) {
            $counter++;
            echo "Текущая итерация: $counter" . PHP_EOL;
            if (file_exists($basePath)) {
                $data = file_get_contents($basePath);
                echo $data;
                unlink($basePath);
            }
            sleep(2);
        }
    }
}