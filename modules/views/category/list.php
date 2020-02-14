<?php
$this->params['breadcrumbs'][] = ['label'=>'分类管理','url'=>'/admin/category/list'];
$this->title = '分类管理';
$this->registerCssFile('admin/css/compiled/user-list.css');
?>

<!-- main container -->


<div class="content">
    <div id="pad-wrapper" class="users-list">
        <div class="row-fluid header">
            <h3>分类列表</h3>
            <div class="span10 pull-right">
                <a href="<?php echo yii\helpers\Url::to(['category/add']) ?>" class="btn-flat success pull-right">
                    <span>&#43;</span>
                    添加新分类
                </a>
            </div>
        </div>

        <?php
        if (Yii::$app->session->hasFlash('info')) {
            echo Yii::$app->session->getFlash('info');
        }
        ?>
        <!-- Users table -->
        <div class="row-fluid table">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="span3 sortable">
                        <span class="line"></span>分类ID
                    </th>
                    <th class="span3 sortable">
                        <span class="line"></span>分类名称
                    </th>
                    <th class="span3 sortable">
                        <span class="line"></span>父类ID
                    </th>
                    <th class="span3 sortable align-right">
                        <span class="line"></span>操作
                    </th>
                </tr>
                </thead>
                <tbody>
                <!-- row -->
                <?php foreach($cates as $cate): ?>
                    <tr class="first">
                        <td>
                            <?= $cate['cateid'] ?>
                        </td>
                        <td>
                            <?= $cate['title'] ?>
                        </td>
                        <td>
                            <?= $cate['parentid']?>
                        </td>
                        <td class="align-right">
                            <a href="<?=  yii\helpers\Url::to(['category/mod', 'cateid' => $cate['cateid']]); ?>">编辑</a>
                            <a href="<?=  yii\helpers\Url::to(['category/del', 'cateid' => $cate['cateid']]); ?>">删除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>



        </div>
        <!-- end users table -->
    </div>
</div>

<!-- end main container -->
