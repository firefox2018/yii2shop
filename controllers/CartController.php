<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/22
 * Time: 9:17
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class CartController extends Controller{

    public $layout = 'layout2';

    public function actionIndex(){
        return $this->render('index');
    }
}