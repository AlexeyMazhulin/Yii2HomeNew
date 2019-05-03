<?php


namespace app\components;


use app\rules\ViewOwnerActivityRule;
use yii\base\Component;

class RbacComponent extends Component
{
    public function getAuthManager(){

        return \Yii::$app->authManager;
    }

    public function generateRbac(){

        $authManager=$this->getAuthManager();

        $authManager->removeAll();

        $admin=$authManager->createRole('admin');
        $user=$authManager->createRole('user');

        $authManager->add($admin);
        $authManager->add($user);

        $createActivity=$authManager->createPermission('createActivity');
        $createActivity->description='Создание активностей';

        $viewAllActivity=$authManager->createPermission('viewAllActivity');
        $viewAllActivity->description='Просмотр любых активностей';

        $viewOwnerRule=new ViewOwnerActivityRule();
        $authManager->add($viewOwnerRule);

        $viewOwnerActivity=$authManager->createPermission('viewOwnerActivity');
        $viewOwnerActivity->description='Просмотр только своих активностей';
        $viewOwnerActivity->ruleName=$viewOwnerRule->name;

        $authManager->add($createActivity);
        $authManager->add($viewAllActivity);
        $authManager->add($viewOwnerActivity);

        $authManager->addChild($user,$createActivity);
        $authManager->addChild($user,$viewOwnerActivity);

        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$viewAllActivity);

        $authManager->assign($user,4);
        $authManager->assign($admin,3);

    }

    public function canCreateActivity(){
        return \Yii::$app->user->can('createActivity');
    }

    public function canViewActivity($activity){
        if(\Yii::$app->user->can('viewAllActivity')){
            return true;
        }

        if(\Yii::$app->user->can('viewOwnerActivity',['activity'=>$activity])){
            return true;
        };

        return false;

    }

}