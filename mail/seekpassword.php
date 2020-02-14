<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<h2>管理员密码修改</h2>
<p>尊敬的<?= Html::encode($adminuser); ?>您好:</p>
<p>请点击以下链接修改管理员密码</p>
<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['/admin/manager/seekpass','adminuser'=>$adminuser,'timestamp'=>$timestamp,'token'=>$token]) ?>
<a href="<?php echo $url; ?>">修改管理员密码</a>
<p>此邮件为系统邮件,请勿回复</p>
