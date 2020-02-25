<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/22
 * Time: 6:38
 */

namespace app\controllers;

use Yii;
use app\controllers\CommonController;
use app\models\Category;
use app\models\Product;

class IndexController extends CommonController{
    public $layout = 'layout1';

    public function actionIndex(){
        $topCategory = Category::getTopCategory();
        $childCategory = Category::getChildCategory();
        $recommendProduct = Product::getRecommendProduct();
        $latestProduct = Product::getLatestProduct();
        return $this->render('index',[
            'topCategory' => $topCategory,
            'childCategory' => $childCategory,
            'recommendProduct' => $recommendProduct,
            'latestProduct' => $latestProduct
        ]);
    }
}