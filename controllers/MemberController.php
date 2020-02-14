<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/22
 * Time: 9:46
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class MemberController extends Controller{

    public $layout = 'layout1';

    public function actionAuth(){
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->login($post)){
                $this->redirect(['index/index']);
            }
        }
        return $this->render('auth',[
            'model' => $model
        ]);
    }

    public function actionReg(){
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->regByEmail($post)){
                Yii::$app->session->setFlash('info','注册邮件已发送,请注意查收.');
            }
        }
        return $this->render('auth',[
            'model' => $model
        ]);
    }


}