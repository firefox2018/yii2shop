<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2020/1/14
 * Time: 20:16
 */

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\data\Pagination;
use app\models\Profile;

class UserController extends Controller
{
    public $layout = 'layout1';

    public function actionUsers(){
        $model = User::find(); //关联profile表查询
        $pager = new Pagination(['totalCount' => $model->count(),'pageSize'=>10]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('users',[
            'users' => $users,
            'pager' => $pager
        ]);
    }

    /**
     * 添加新会员
     * @return string
     */
    public function actionReg(){
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            //var_dump($post);
            //Yii::$app->end();
            if($model->reg($post)){
                Yii::$app->session->setFlash('info','注册成功!');
            }
        }
        return $this->render('reg',[
            'model' => $model
        ]);
    }

    /**
     * 删除会员
     */
    public function actionDel(){
        $userid = Yii::$app->request->get('userid');
        $model = new User();
        if($model->del($userid)){
            Yii::$app->session->setFlash('info','删除成功!');
        }
        $this->redirect(['user/users']);

    }
}