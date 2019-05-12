<?php


namespace app\controllers;


use yii\web\Controller;

class RbacController extends Controller
{
    public function actionGen(){
        $rbac=\Yii::$app->rbac;

        $rbac->generateRbac();
    }

}