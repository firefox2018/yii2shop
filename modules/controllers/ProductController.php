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
use yii\data\Pagination;

class ProductController extends Controller{

    public $layout = 'layout1';
    private $ak = "WQIKl3lEm7xYEIreG8q60m1Z3a6wDUGjnacdhGay";
    private $sk = "9IQYq1xMKZSPGcvf3C6qxxnqoZ1Pg83aAfTbwHDF";
    private $domain  = "http://q5bhk01zo.bkt.clouddn.com";
    private $bucket = "crazyfox";

    /*
     * 展示商品
     */
    public function actionList(){
        $query = Product::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 10]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('products',[
            'model' => $model,
            'pages' => $pages
        ]);
    }

    /**
     * 增加商品
     * @return string
     */
    public function actionAdd(){
        $model = new Product();
        $cates = Category::getList();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $images = $this->upload(); // 上传图片到七牛云.
            if(!$images){
                $model->addError('cover','封面图不能为空');
            }else{
                $post['Product']['cover'] = $images['cover'];
                $post['Product']['pics'] = $images['pics'];
            }
            if($images && $model->add($post)){
                Yii::$app->session->setFlash("info","添加成功");
            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }
        return $this->render('add',[
            'model' => $model,
            'cates' => $cates
        ]);
    }

    /**
     * 上传图片到七牛云
     * @return array|bool
     */
    private function upload(){
        if($_FILES['Product']['error']['cover'] >0){
            return false;
        }

        $qiniu = new Qiniu($this->ak,$this->sk,$this->domain,$this->bucket);
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
            $pics[$key] = $qiniu->getLink($key);
        }
        return ['cover'=>$cover,'pics'=>json_encode($pics,true)];
    }

    /**
     * 修改是否热卖,促销,上架,推荐
     */
    public function actionEdit(){
        $params = Yii::$app->request->get();
        $res = Product::updateAll([$params['type']=>abs(1-$params['currentStatus'])],'productid=:id',[':id'=>$params['productid']]);
        if(!$res){
            Yii::$app->session->setFlash('info','修改状态失败');
        }else{
            Yii::$app->session->setFlash('info','修改状态成功');
        }
        $this->redirect(['product/list']);
    }

    /**
     * 编辑商品
     * @return bool|string
     */
    public function actionModify(){
        $productId = Yii::$app->request->get('productid');
        $cates = Category::getList();
        $product = Product::findOne($productId);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $cover = $_FILES['Product']['tmp_name']['cover'];
            $pics = $_FILES['Product']['tmp_name']['pics'];
            $qiniu = new Qiniu($this->ak,$this->sk,$this->domain,$this->bucket);
            if($_FILES['Product']['error']['cover'] == 0){ //上传了新的封面图
                $key = uniqid();
                $qiniu->uploadFile($cover,$key);
                $cover = $qiniu->getLink($key);
                $post['Product']['cover'] = $cover;
                $qiniu->delete(basename($product->cover));
            }else{
                $post['Product']['cover'] = $product->cover;
            }
            $thumbnail = [];
            if(count($pics)>=1 && $pics[0]){ //判断是否上传了新的缩略图
                foreach($pics as $k=>$pic){
                    if($_FILES['Product']['error']['pics'][$k] > 0){
                        continue;
                    }
                    $key = uniqid();
                    $qiniu->uploadFile($pic,$key);
                    $thumbnail[$key] = $qiniu->getLink($key);
                }
                $post['Product']['pics'] = json_encode(array_merge(json_decode($product->pics,true),$thumbnail),true);
            }else{
                $post['Product']['pics'] = $product->pics;
            }
            if($product->load($post) && $product->save()){
                Yii::$app->session->setFlash('info','修改成功');
            }
        }
        return $this->render('mod',[
            'model' => $product,
            'cates' => $cates
        ]);
    }

    /**
     * 删除指定缩略图
     * @return bool
     */
    public function actionDeleteThumbnail(){
        $productId = Yii::$app->request->get('productid');
        $key = Yii::$app->request->get('key');
        if (!$productId || !$key) return false;
        $product = Product::findOne($productId);
        $thumbnail = json_decode($product->pics,true);
        $qiniu = new Qiniu($this->ak,$this->sk,$this->domain,$this->bucket);
        $qiniu->delete(basename($thumbnail[$key]));
        foreach($thumbnail as $k=>$v){
            if($key === $k){
                unset($thumbnail[$k]);
            }
        }
        $product->pics = json_encode($thumbnail,true);
        $product->save();
        $this->redirect(['product/modify','productid' => $productId]);
    }
}