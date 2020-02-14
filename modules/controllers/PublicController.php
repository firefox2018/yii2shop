<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/22
 * Time: 10:32
 */

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\modules\models\ShopAdmin;

class PublicController extends Controller{

    public $layout = false;

    /**
     * 管理员登录
     * @return string
     */
    public function actionLogin(){
        $model = new ShopAdmin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->login($post)){
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }
        return $this->render('login',[
            'model' => $model
        ]);
    }

    /**
     * 退出登录
     * @return \yii\web\Response
     */
    public function actionLogout(){
        Yii::$app->session->removeAll();
        if(!isset(Yii::$app->session['admin']['isLogin'])){
            return $this->redirect(['public/login']);
        }
        return $this->goBack();
    }

    /**
     * 找回密码
     * @return string
     */
    public function actionSeekpassword(){
        $model = new ShopAdmin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->seekpass($post)){
                Yii::$app->session->setFlash('info','验证邮件已经发送至注册邮箱,请注意查收.');
            }
        }
        return $this->render('seekpass',[
            'model' => $model,
        ]);
    }
}