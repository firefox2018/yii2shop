<?php

namespace app\modules\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_admin".
 *
 * @property int $adminid
 * @property string $adminuser
 * @property string $adminpass
 * @property string $adminemail
 * @property int $logintime
 * @property int $loginip
 * @property int $createtime
 */
class ShopAdmin extends ActiveRecord implements IdentityInterface
{
    public $rememberMe = 0;
    public $repeatpass;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "{{%admin}}";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['adminuser','required','message'=>'管理员帐号不能为空','on'=>['login','seekpass','changepass','reg','changeemail']],
            ['adminuser','unique','message'=>'管理员帐号已经存在','on'=>'reg'],
            ['adminpass','required','message'=>'登录密码不能为空','on'=>['login','reg','changepass']],
            ['adminemail','required','message'=>'邮箱不能为空','on'=>['seekpass','reg','changeemail']],
            ['adminemail','validateEmail','on'=>'seekpass'],
            ['adminemail','unique','message'=>'该邮箱已被注册','on'=>'reg'],
            ['rememberMe','boolean','on'=>'login'],
            ['repeatpass','required','on'=>['changepass','reg'],'message'=>'重复密码不能为空'],
            ['adminpass','validatePass','on'=>['login','changeemail']],
            ['adminpass','compare','compareAttribute'=>'repeatpass','on'=>['reg','changepass'],'message'=>'两次密码不一致'],
            [['logintime', 'loginip'], 'integer','on'=>'login'],
            ['createtime','integer','on'=>'reg'],
            [['adminuser', 'adminpass','repeatpass'], 'string', 'max' => 32,'on'=>['login','reg','changepass']],
            [['adminemail'], 'string', 'max' => 50,'on'=>['seekpass','reg','changeemail']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'adminid' => '管理员ID',
            'adminuser' => '用户名',
            'adminpass' => '密码',
            'repeatpass' => '重复密码',
            'adminemail' => '邮箱',
            'logintime' => '登录时间',
            'loginip' => '登录IP',
            'createtime' => '创建时间',
            'rememberMe' => '记住帐号'
        ];
    }

    /**
     * 验证登录用户密码是否一致
     */
    public function validatePass(){
        if(!$this->hasErrors()){
            $user = self::find()->where('adminuser=:user and adminpass=:pass',[':user'=>$this->adminuser,':pass'=>md5($this->adminpass)])->one();
            if(is_null($user)){
                $this->addError('adminpass','用户名或者密码错误');
            }
        }
    }

    /**
     * 获取登陆管理员对象
     * @return array|null|ActiveRecord
     */
    public function getAdmin(){
        return self::find()->where('adminuser = :user',[':user'=>$this->adminuser])->one();
    }

    /**
     * 加载用户提交信息,执行登录验证
     * @param $post
     * @return bool
     */
    public function login($post){
        $this->scenario = 'login';
        if($this->load($post) && $this->validate()){
            $lifeTime = $this->rememberMe ? 24*3600 : 0 ;
            if(Yii::$app->admin->login($this->getAdmin(), $lifeTime)){
                $this->updateAll(
                    ['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIP)],
                    'adminuser = :user',[':user'=>$this->adminuser]);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 验证注册邮箱与用户名是否一致
     */
    public function validateEmail(){
        if(!$this->hasErrors()){
            $userInfo = self::find()->where('adminuser = :user and adminemail = :email',[':user'=>$this->adminuser,':email'=>$this->adminemail])->one();
            if(is_null($userInfo)){
                $this->addError('adminemail','用户名邮箱不匹配');
            }
        }
    }

    /**
     * 找回密码
     * @param $post
     */
    public function seekpass($post){
        $this->scenario = 'seekpass';
        if($this->load($post) && $this->validate()){
            $time = time();
            $token = $this->createToken($this->adminuser,$time);
            $mailer = Yii::$app->mailer->compose('seekpassword',[
                'adminuser' => $this->adminuser,
                'timestamp' => $time,
                'token' => $token
            ]);
            $mailer->attachContent("测试附件",['fileName'=>'attach.txt','contentType'=> 'text/plain']);
            $mailer->setTo($this->adminemail);
            $mailer->setSubject('管理员密码修改');
            if($mailer->send()){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $user
     * @param $time
     * @return string 邮件校验码
     */
    public function createToken($user,$time){
        return md5(md5($user).base64_encode(Yii::$app->request->userIP).md5($time));
    }

    /**
     * 修改管理员密码
     * @param $data
     */
    public function changePassword($data){
        $this->scenario = 'changepass';
        if($this->load($data) && $this->validate()){
            return $this->updateAll(['adminpass'=>md5($this->adminpass)],'adminuser = :user',[':user'=>$this->adminuser]);
        }
        return false;
    }

    /**
     * 添加管理员
     * @param $post
     */
    public function reg($post){
        $this->scenario = 'reg';
       /* $post['ShopAdmin']['adminpass'] = md5($post['ShopAdmin']['adminpass']);
        $post['ShopAdmin']['repeatpass'] = md5($post['ShopAdmin']['repeatpass']);
        if($this->load($post) && $this->save()){ //加载数据到模型. $this->save() 会自动验证数据.
            return true;
        }*/
       if($this->load($post) && $this->validate()){
           $post['ShopAdmin']['adminpass'] = md5($post['ShopAdmin']['adminpass']);
           if($this->save(false)){ // 这里save()方法设置false参数,表示不再进行验证, 比上面的方法更简洁.
               return true;
           }
           return false;
       }
        return false;

    }

    /**
     * 修改当前登录管理员邮箱
     * @param $post
     * @return bool|int
     */
    public function changeemail($post){
        $this->scenario = 'changeemail';
        if(Yii::$app->admin->isGuest){
            return false;
        }
        if($this->load($post) && $this->validate()){
            return  $this->updateAll(['adminemail' => $post['ShopAdmin']['adminemail']], 'adminuser=:user',[':user'=>Yii::$app->admin->identity->adminuser]);
        }
        return false;
    }
    /**
     * @param int|string $id 用户id
     * @return null|static 返回用户实例
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return static::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        return static::findOne(['access_token'=>$token]);
    }

    public function getId(){
        return $this->adminid;
    }

    public function getAuthKey(){
        return $this->auth_key;
    }

    public function validateAuthKey($authKey){
        return $this->auth_key === $authKey;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($insert){ //表示当前是插入数据
                $this->createtime = time();
            }
        }
        return true;
    }
}
