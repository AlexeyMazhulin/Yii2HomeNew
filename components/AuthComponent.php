<?php


namespace app\components;


use app\models\Users;
use yii\base\Component;


class AuthComponent extends Component
{
    public function getModel(){
        return new Users();
    }

    public function authUser(&$model):bool{
        $model->setAuthorisationScenario();

        if(!$model->validate(['email','password'])){
            return false;
        }
        $user=$this->getUserFromEmail($model->email);

        if(!$this->checkPassword($model->password,$user->password_hash)){
            $model->addError('password','Неверный пароль');
        }
        return \Yii::$app->user->login($user,3600);

    }

    private function checkPassword($password,$password_hash){
        return \Yii::$app->security->validatePassword($password,$password_hash);
    }

    private function getUserFromEmail($email){
        return Users::find()->andWhere(['email'=>$email])->one();
    }


    public function createUser(&$model):bool{
        $model->setRegistrationScenario();
        $model->password_hash=$this->hashPassword($model->password);
        $model->auth_key=$this->generateAuthKey();

        if($model->save()){

            return true;
        }

        return false;
    }

    private function generateAuthKey(){
        return \Yii::$app->security->generateRandomString();
    }

    private function hashPassword($password){
        return \Yii::$app->security->generatePasswordHash($password);
    }

}