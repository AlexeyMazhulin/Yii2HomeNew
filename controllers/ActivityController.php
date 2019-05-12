<?php


namespace app\controllers;


use app\base\BaseController;
use app\controllers\actions\ActivityCreateAction;
use app\controllers\actions\ActivityEditAction;
use app\models\Activity;
use yii\web\HttpException;

class ActivityController extends BaseController
{

    private function getRbac(){
        return \Yii::$app->rbac;
    }

   public function actions()
   {
       return [
         'create' => ['class'=>ActivityCreateAction::class,
                      'rbac'=>$this->getRbac()
                     ],
          'edit' => ['class'=>ActivityEditAction::class,
               'rbac'=>$this->getRbac()
           ]
       ];
   }


    public function actionView($id){
        $model=\Yii::$app->activity->getModel();
        $model=$model::find()->andWhere(['id'=>$id])->one();

        if(!$this->getRbac()->canViewActivity($model)){
            throw new HttpException(403,'Access denied view Activity');
        }

        return $this->render('view',['model'=>$model]);
    }

    public function actionEdit($id){
        $model=\Yii::$app->activity->getModel();
        $model=$model::find()->andWhere(['id'=>$id])->one();

        if(!$this->getRbac()->canEditActivity($model)){
            throw new HttpException(403,'Access denied view Activity');
        }

        return $this->render('edit',['model'=>$model]);
    }


}
