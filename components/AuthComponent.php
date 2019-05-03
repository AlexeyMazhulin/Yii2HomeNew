<?php


namespace app\components;


use app\models\Users;
use yii\base\Component;

class AuthComponent extends Component
{
    public function getModel(){
        return new Users();
    }

    public function createUser(&$model):bool{

    }

}