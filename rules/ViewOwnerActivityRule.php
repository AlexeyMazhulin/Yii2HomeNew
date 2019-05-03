<?php


namespace app\rules;


use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Rule;

class ViewOwnerActivityRule extends Rule
{
    public $name='viewOwnerActivity';

    public function execute($user, $item, $params)
    {
       $activity=ArrayHelper::getValue($params,'activity');
       if(!$activity){
           return false;
       }

       return $activity->user_id==\Yii::$app->user->getIdentity()->id;

    }
}