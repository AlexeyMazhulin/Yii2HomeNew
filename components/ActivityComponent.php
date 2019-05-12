<?php

namespace app\components;

use app\components\FileComponent;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\Activity;
use app\components\RbacComponent;


class ActivityComponent extends Component
{
    public $activity_class;

    /** @var FileComponent */
    public $file_component;


    public function init(){

        parent:: init();

        if (empty($this->activity_class)){
            throw new \Exception('Need activity_class param');
        }
        $this->file_component=\Yii::createObject(['class'=>FileComponent::class]);
    }

    public function getModel(){
        return new $this->activity_class;
    }

    public function createActivity(&$model):bool{

        $model->user_id=\Yii::$app->user->id;

        if(!$model->save()){
            return false;
        };


        $model->file=$this->file_component->getUploadedFile($model,'file');

        if($model->file) {
            foreach ($model->file as $oneFile) {

                $path = $this->file_component->genFilePath($this->file_component->genFileName($oneFile));
                $pathArray[] =basename($path);

                if (!$this->file_component->saveUploadedFile($oneFile, $path)) {
                    $model->addError('file', 'не удалось сохранить файл');
                    return false;
                } else {
                    $model->filename = $pathArray;

                };


            }
        }



        return true;
    }

    public function getColumns()
    {
        $model = $this->getModel();
        $includedInListColumns = [
            'id' => 'ID события',
            'title' => $model->getAttributeLabel('title'),
            'dateStart' => $model->getAttributeLabel('dateStart'),
            'isBlocked' => $model->getAttributeLabel('isBlocked'),
        ];
        return $includedInListColumns;
    }
    public function getAllActivities()
    {
        $model = $this->getModel();
        $filter = null;
        /**
         * @var $rbacComponent RbacComponent
         */
        $rbacComponent = \Yii::createObject([
            'class' => RbacComponent::class,]);
        $viewAll = $rbacComponent->canViewAllActivities();
        if(!$viewAll) {
            $viewMy = $rbacComponent->canViewOwnActivities(\Yii::$app->user->getId());
        }
        $model = $model::find();
        if(!$viewAll && $viewMy) {
            $model = $model->where(['user_id' => \Yii::$app->user->getId()]);
        } elseif(!$viewAll) {
            throw new HttpException(403, 'You have no permissions to read the list');
        }
        $arData = $model->asArray()->all();
        $isBlockingCode = 'isBlocked';
        $startDateCode = 'dateStart';
        foreach ($arData as $key => $arDatum) {
            $arData[$key][$isBlockingCode] = $arDatum[$isBlockingCode] == true ? 'Да' : "Нет";
            $arData[$key][$startDateCode] = Date::convertFromFormatToString($arDatum[$startDateCode], "&mdash;");
        }
        return $arData;
    }
    public function getActivityById($id)
    {
        $model = $this->getModel();
        $model = $model::find()
            ->select(['*',])
            ->where(['id' => $id])
            ->one();
        $files = $model->getActivityFiles()->asArray()->all();
        $arActivity = $model->getAttributes();
        foreach ($files as $file) {
            $arActivity['uploadedFile'][] = $file['file_path'];
        }
        return $arActivity;
    }



}