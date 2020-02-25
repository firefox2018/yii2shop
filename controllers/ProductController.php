<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/22
 * Time: 9:10
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Product;
use yii\data\Pagination;

class ProductController extends Controller{

    public $layout = 'layout2';

    /**
     * 显示分类商品信息
     * @return bool|string
     */
    public function actionIndex(){
        $cateid = Yii::$app->request->get('cateid');
        if(!$cateid) return false;
        $model = Product::find()->where('cateid=:id',[':id'=>$cateid]);
        $pager = new Pagination(['totalCount' => $model->count(),'pageSize'=>10]);
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('index',[
            'products' => $products
        ]);
    }

    /**
     * 显示商品详情
     * @return string
     */
    public function actionDetail(){
        $productId = Yii::$app->request->get('productid');
        if(!$productId) return false;
        $product = Product::findOne($productId);
        return $this->render('detail',[
            'product' => $product
        ]);
    }
}