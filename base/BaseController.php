<?php
/**
 * Created by PhpStorm.
 * User: Moka-tian
 * Date: 20.04.2019
 * Time: 20:24
 */

namespace app\base;

use yii\web\Controller;
use yii\web\HttpException;

class BaseController extends Controller
{

    public function beforeAction($action)
    {
       if(\Yii::$app->user->isGuest){
           return $this->redirect(['/auth/sign-in']);
       }
       return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $page = \Yii::$app->request->url;
        \Yii::$app->session->set('page_url',$page);

        return parent::afterAction($action, $result);
    }
}