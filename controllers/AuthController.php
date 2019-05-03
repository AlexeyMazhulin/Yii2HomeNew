<?php


namespace app\controllers;


use app\components\AuthComponent;
use yii\web\Controller;

class AuthController extends Controller
{
    public $component;

    public function init()
    {
        parent::init();

        $this->component=\Yii::createObject(['class'=>AuthComponent::class]);
    }

    public function actionSignUp(){
        $model=$this->component->getModel();

        return $this->render('signup',['model'=>$model]);
    }
}