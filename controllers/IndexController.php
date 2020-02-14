<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2019/12/22
 * Time: 6:38
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller{
    public $layout = 'layout1';

    public function actionIndex(){
        return $this->render('index');
    }
}