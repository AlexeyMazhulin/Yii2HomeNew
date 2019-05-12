<?php


namespace app\models;


use app\models\rules\StopTitleValidator;
use yii\base\Model;
use app\components\FileComponent;


class Activity extends ActivityBase
{
    public $repeatCount;
    private $repeatCountList=[0=>'не повторять',1=> 'Ежедневно',2=> 'Еженедельно'];

    public function getRepeatCountList(){
        return $this->repeatCountList;
    }

    public $file;
    public $filename;


    public function beforeValidate()
    {

        if(!empty($this->dateStart)){
            $date=\DateTime::createFromFormat('d.m.Y',$this->dateStart);
            if($date){
                $this->dateStart=$date->format('Y-m-d');
            }
        }
        return parent::beforeValidate();
    }

    public function rules()
    {
        return array_merge([
            ['title','required'],
            ['description','string','min'=>3],
            ['dateStart','date','format' => 'Y-m-d'],
            ['email','email'],
            ['email','required','when' => function($model){
                return $model->useNotification ==1;
            }],
            [['title'],StopTitleValidator::class],
            ['repeatCount','number','min' => 0],
            [['isBlocked','useNotification'],'boolean'],
            [['file'],'file','extensions'=>['jpg','png','pdf'],'maxFiles' => 5],
            [['filename'],'string']

        ],parent::rules());
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок события',
            'description' => 'Описание',
            'dateStart' => 'Дата начала',
            'repeatCountList' => 'Повторять',
            'repeatCount' => 'Количество повторов',
            'isBlocked' => 'Блоктрующее событие'
        ];
    }
}