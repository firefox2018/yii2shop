    <link rel="stylesheet" href="assets/admin/css/compiled/user-list.css" type="text/css" media="screen" />
    <!-- main container -->

        
    <div class="content">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>商品列表</h3>
                    <div class="span10 pull-right">
                        <a href="<?php echo yii\helpers\Url::to(['product/add']) ?>" class="btn-flat success pull-right">
                            <span>&#43;</span>
                            添加新商品
                        </a>
                    </div>
                </div>

                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span6 sortable">
                                    <span class="line"></span>商品名称
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>商品库存
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>商品单价
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否热卖
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否促销
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>促销价
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否上架
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否推荐
                                </th>

                                <th class="span3 sortable align-right">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- row -->

                        </tbody>
                    </table>
                </div>
                <div class="pagination pull-right">

                </div>
                <!-- end users table -->
            </div>
        </div>

    <!-- end main container -->
