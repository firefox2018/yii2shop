<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/25
 * Time: 13:44
 */

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\modules\models\ShopAdmin;
use app\modules\models\AdminSearch;
use yii\data\Pagination;

class ManagerController extends Controller{
    public $layout = 'layout1';
    /**
     * 找回密码
     * @return string
     */
    public function actionSeekpass(){
        $this->layout = false;
        $model = new ShopAdmin();
        $request = Yii::$app->request;
        if($request->isPost){
            $post = $request->post();
            if($model->changePassword($post)){
                Yii::$app->session->setFlash('info','密码修改成功!');
            }
        }
        $user = $request->get('adminuser');
        $timestamp = $request->get('timestamp');
        $token = $request->get('token');
        if((time()-$timestamp)>5*60 || $token != $model->createToken($user,$timestamp)){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $model->adminuser = $user;
        return $this->render('seekpassword',[
            'model' => $model
        ]);
    }

    /**
     * 展示管理员管理页面
     */
    public function actionManagers(){
        $admin = ShopAdmin::find();
        $count = $admin->count(); // 获取总条数
        $pageSize = Yii::$app->params['pageSize']['manager'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $managers = $admin->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('managers',[
            'pager' => $pager,
            'managers' => $managers
        ]);
    }

    /**
     * 添加管理员
     */
    public function actionReg(){
        $model = new ShopAdmin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->reg($post)){
                Yii::$app->session->setFlash('info','添加成功');
            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }
        return $this->render('reg',[
            'model' => $model,
        ]);
    }

    /**
     * 删除管理员
     */
    public function actionDel(){
        $adminid = Yii::$app->request->get('adminid');
        if(empty($adminid)){
            $this->redirect(['manager/managers']);
        }
        $model = new ShopAdmin();
        if($model->deleteAll('adminid=:id',[':id'=>$adminid])){
            Yii::$app->session->setFlash('info','删除成功!');
            $this->redirect(['manager/managers']);
        }

    }

    /**
     * 修改当前登录管理员邮箱
     * @return string
     */
    public function actionChangeemail(){
        $model = ShopAdmin::find()->where('adminuser= :user',[':user' => Yii::$app->admin->identity->adminuser])->one();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->changeemail($post)){
                Yii::$app->session->setFlash('info','修改邮箱成功!');
            }
        }
        return $this->render('changeemail',[
            'model' => $model
        ]);
    }

    public function actionChangepass(){
        $model = ShopAdmin::find()->where('adminuser=:user',[':user'=>Yii::$app->admin->identity->adminuser])->one();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->changePassword($post)){
                Yii::$app->session->setFlash('info','修改密码成功!');
            }
        }
        return $this->render('changepass',[
            'model' => $model
        ]);
    }

}