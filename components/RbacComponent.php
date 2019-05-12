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

        $editAllActivities = $authManager->createPermission('editAllActivities');
        $editAllActivities->description = 'Редактирование событий';

        $viewOwnerRule=new ViewOwnerActivityRule();
        $authManager->add($viewOwnerRule);

        $viewOwnerActivity=$authManager->createPermission('viewOwnerActivity');
        $viewOwnerActivity->description='Просмотр только своих активностей';
        $viewOwnerActivity->ruleName=$viewOwnerRule->name;


        $editOwnActivities = $authManager->createPermission('editOnwActivities');
        $editOwnActivities->description = 'Редактирование своих событий';
        $editOwnActivities->ruleName = $viewOwnerRule->name;


        $authManager->add($createActivity);
        $authManager->add($viewAllActivity);
        $authManager->add($viewOwnerActivity);
        $authManager->add($editAllActivities);
        $authManager->add($editOwnActivities);

        $authManager->addChild($user,$createActivity);
        $authManager->addChild($user,$viewOwnerActivity);
        $authManager->addChild($user, $editOwnActivities);

        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$viewAllActivity);
        $authManager->addChild($admin, $editAllActivities);

        $authManager->assign($user,1);
        $authManager->assign($admin,2);

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

    public function canViewOwnActivities($ownerId)
    {
        if(\Yii::$app->user->can('viewOwnerActivity',['ownerId' => $ownerId])){
            return true;
        };

        return false;

    }

    public function canEditActivity(int $ownerId)
    {
        if ($this->canEditAllActivities()) {
            return true;
        }
        return $this->canEditOwnActivities($ownerId);
    }

    public function canEditAllActivities()
    {
        {
            if(\Yii::$app->user->can('editAllActivities')){
                return true;
            };

            return false;

        }
    }
    public function canEditOwnActivities(int $ownerId)
    {

            if(\Yii::$app->user->can('editOnwActivities',['ownerId'=>$ownerId])){
                return true;
            };

            return false;

    }




}