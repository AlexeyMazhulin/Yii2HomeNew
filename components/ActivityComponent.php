<?php

namespace app\components;

use app\components\FileComponent;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\Activity;



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


}