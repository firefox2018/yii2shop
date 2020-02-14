<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2020/1/16
 * Time: 21:16
 */

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use yii\data\Pagination;

class CategoryController extends Controller{

    public $layout = 'layout1';

    /**
     * 展示所有分类
     * @return string
     */
    public function actionList(){
        $model = new Category();
        $cates = $model->getCates();
        return $this->render('list',[
            'cates' => $cates,
        ]);
    }

    /**
     * 添加分类
     * @return string
     */
    public function actionAdd(){
        $model = new Category();
        $list = $model->getCates();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->add($post)){
                Yii::$app->session->setFlash('info','添加成功!');
            }
        }
        return $this->render('add',[
            'model'=>$model,
            'list' => $list
        ]);
    }

    /**
     * 修改分类
     */
    public function actionMod(){
        $cateid = Yii::$app->request->get('cateid');
        $model = Category::findOne($cateid);
        $list = $model->getCates();
        if(Yii::$app->request->isPost){
           $post = Yii::$app->request->post();
           $model->scenario = 'mod';
           if($model->load($post) && $model->save()){
               Yii::$app->session->setFlash('info','修改成功!');
           }

        }
        return $this->render('modify',[
            'model'=> $model,
            'list' => $list
        ]);
    }


    public function actionDel(){
        try{
            $cateid = Yii::$app->request->get('cateid');
            $model = new Category();
            if(!$cateid){
                throw new \Exception('请求的分类id不存在');
            }
            $childs = Category::find()->where('parentid=:id',[':id'=>$cateid])->all();

            if(!empty($childs)){
                throw new \Exception('请先删除当前分类下的子类');
            }
            $model->deleteAll('cateid=:id',[':id'=>$cateid]);
            Yii::$app->session->setFlash('info','删除成功');
            $this->redirect(['category/list']);
        }catch(\Exception $e){
            Yii::$app->session->setFlash('info',$e->getMessage());
            $this->redirect(['category/list']);
        }


    }





}