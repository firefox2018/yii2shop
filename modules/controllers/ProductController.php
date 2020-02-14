<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2020/2/7
 * Time: 13:07
 */

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\models\Product;
use app\models\Category;
use crazyfd\qiniu\Qiniu;

class ProductController extends Controller{

    public $layout = 'layout1';

    public function actionList(){
        $model = new Product();
        return $this->render('products',[
            'model' => $model
        ]);
    }

    /**
     * 增加商品
     * @return string
     */
    public function actionAdd(){
        $model = new Product();
        $category = new Category();
        $cates = $category->getList();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $images = $this->upload(); // 上传图片到七牛云.
            if(!$images){
                $model->addError('cover','封面不能为空');
            }
            $post['cover'] = $images['cover'];
            $post['pics'] = $images['pics'];
            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash("info","添加商品成功!");
                $this->redirect(["product/list"]);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',[
            'model' => $model,
            'cates' => $cates
        ]);
    }

    private function upload(){
        if($_FILES['Product']['error']['cover'] >0){ //上传封面图有错误
            return false;
        }
        $ak = "WQIKl3lEm7xYEIreG8q60m1Z3a6wDUGjnacdhGay";
        $sk = "9IQYq1xMKZSPGcvf3C6qxxnqoZ1Pg83aAfTbwHDF";
        $domain  = "q5bhk01zo.bkt.clouddn.com";
        $bucket = "crazyfox";
        $qiniu = new Qiniu($ak,$sk,$domain,$bucket);
        $key = uniqid();
        $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
        $cover = $qiniu->getLink($key);
        $pics = [];
        foreach($_FILES['Product']['tmp_name']['pics'] as $k=>$file){
            if($_FILES['Product']['error']['pics'][$k] > 0){
                continue;
            }
            $key = uniqid();
            $qiniu->uploadFile($file,$key);
            $pics[] = $qiniu->getLink($key);
        }
        return ['cover'=>$cover,'pics'=>json_encode($pics)];

    }
}