<?php


namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\models\Activity;
use yii\base\Action;
use app\components\FileComponent;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActivityEditAction extends Action
{

    public $rbac;

    public function run()
    {
        $activityId = \Yii::$app->request->get('id');

       // if(!$this->rbac->canEditActivity($activityId)){
        if(!$this->rbac->canEditActivity(1)){
            throw new HttpException(403,'Access denied edit activity');
        }

        $model=\Yii::$app->activity->getModel();
        $model = $model::find()->where(['id' => $activityId])->one();
        $comp=\Yii::createObject(['class'=>ActivityComponent::class,'activity_class'=>Activity::class,'file_component' => FileComponent::class]);
        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());

            if(\Yii::$app->request->isAjax){
                \Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if($comp->getAllActivities($model)){
                return $this->controller->render('edit',['model' => $model]);

            };

        }


        return $this->controller->render('edit',['model'=>$model]);

    }

}