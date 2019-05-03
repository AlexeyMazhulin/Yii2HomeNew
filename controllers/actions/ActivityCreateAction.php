<?php


namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\models\Activity;
use yii\base\Action;
use app\components\FileComponent;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActivityCreateAction extends Action
{
    public function run()
    {
        $model=\Yii::$app->activity->getModel();
        $comp=\Yii::createObject(['class'=>ActivityComponent::class,'activity_class'=>Activity::class,'file_component' => FileComponent::class]);
        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());

            if(\Yii::$app->request->isAjax){
             \Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

        if($comp->createActivity($model)){
                return $this->controller->render('view',['model' => $model]);

        };

        }


        return $this->controller->render('create',['model'=>$model]);

    }

}