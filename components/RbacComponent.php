<?php


namespace app\components;


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

        $viewOwnerActivity=$authManager->createPermission('viewOwnerActivity');
        $viewOwnerActivity->description='Просмотр только своих активностей';

        $authManager->add($createActivity);
        $authManager->add($viewAllActivity);
        $authManager->add($viewOwnerActivity);

        $authManager->addChild($user,$createActivity);
        $authManager->addChild($user,$viewOwnerActivity);

        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$viewAllActivity);

            }

}