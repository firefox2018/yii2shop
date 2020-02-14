<?php

namespace app\modules\controllers;

use yii\web\Controller;

/**
 * Default controller for the `Admin` module
 */
class DefaultController extends Controller
{

    public $layout = 'layout1';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
