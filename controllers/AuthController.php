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

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
        }

        if($this->component->createUser($model)){
            return $this->redirect(['/auth/sign-in']);
        }

        return $this->render('signup',['model'=>$model]);
    }

    public function actionSignIn(){
        $model=$this->component->getModel();

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
        }

        if($this->component->authUser($model)){
            return $this->redirect(['/activity/create']);
        }

        return $this->render('signin',['model'=>$model]);
    }
}