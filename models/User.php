<?php

namespace app\models;

use Yii;
use app\models\Profile;

/**
 * This is the model class for table "shop_user".
 *
 * @property int $userid 主键ID
 * @property string $username 用户名
 * @property string $userpass 密码
 * @property string $useremail 邮箱
 * @property int $createtime
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $repass;
    public $loginname;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime'], 'integer','on' => ['reg','regbyemail']],
            ['loginname','required','message'=>'用户名或邮箱不能为空','on'=>'login'],
            ['username','unique','message'=>'用户名已经存在','on'=>['reg','regbyemail']],
            ['username','required','message'=>'用户名不能为空','on'=>['reg','regbyemail']],
            ['userpass','required','message'=>'密码不能为空','on'=>['reg','login']],
            ['userpass','validatePass','message'=>'用户名或者密码错误','on'=>['login']],
            ['useremail','required','message'=>'邮箱不能为空','on'=>['reg','regbyemail']],
            ['useremail','email','message'=>'邮箱格式不正确','on'=>['reg','regbyemail']],
            ['useremail','unique','message'=>'邮箱已经存在','on'=>['reg','regbyemail']],
            ['repass','required','message'=>'重复密码不能为空','on'=>['reg']],
            ['repass','compare','compareAttribute'=>'userpass','message'=>'两次输入密码不一致','on'=>['reg']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userid' => '用户ID',
            'username' => '用户名',
            'userpass' => '用户密码',
            'useremail' => '邮箱',
            'createtime' => '创建时间',
            'repass' => '重复密码'
        ];
    }

    /**
     * 验证用户名 密码是否正确
     */
    public function validatePass(){
        if(!$this->hasErrors()){
            $loginName = "username";
            if(preg_match("/@/",$this->loginname)==1){
                $loginName = "useremail";
            }
            $model = self::find();
            $users = $model->where($loginName.'=:name',[':name'=>$this->loginname])->one();
            //$sql = $model->createCommand()->getRawSql();
            if(is_null($users) || !Yii::$app->security->validatePassword($this->userpass,$users['userpass'])){
                $this->addError('userpass',"用户名或密码错误");
            }
        }

    }

    /**
     * 关联profile表
     * @return \yii\db\ActiveQuery
     */
    public function getProfile(){
        return $this->hasOne(Profile::className(),['userid'=>'userid']);
    }

    /**
     * 后台添加会员
     * @param $post
     * @return bool
     */
    public function reg($post){
        $this->scenario = 'reg';
        if($this->load($post) && $this->validate()){
            $this->userpass = Yii::$app->getSecurity()->generatePasswordHash($this->userpass);
            return $this->save(false);
        }
        return false;
    }

    /**
     * 删除会员  同时删除user, profile表, 开启事务
     * @param $userid
     * @return bool
     */
    public function del($userid){
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if($profile = Profile::find()->where('userid=:userid',[':userid'=>$userid])->one()){
                if(!$profile->delete()){
                    throw new \Exception();
                }

            }
            if(!self::deleteAll('userid=:userid',[':userid'=>$userid])){
                throw new \Exception();
            }
            $transaction->commit();
            return true;
        }catch(\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * 通过邮件注册会员
     * @param $data
     */
    public function regByEmail($data){
        $this->scenario = 'regbyemail';
        $userpass = uniqid();
        if($this->load($data) && $this->validate()){
            $this->userpass = Yii::$app->security->generatePasswordHash($userpass);
            $mailer = Yii::$app->mailer->compose('reg',[
                'userpass' => $userpass
            ]);
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject("商城注册");
            if($mailer->send()){
                if($this->save(false)){
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * 前台用户登录
     * @param $post
     * @return bool
     */
    public function login($post){
        $this->scenario = 'login';
        if($this->load($post) && $this->validate()){
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    public function getUser(){
        return self::find()->where('username=:loginname or useremail=:loginname',[':loginname'=>$this->loginname])->one();
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($insert){
                $this->createtime = time();
            }
            return true;
        }
        return false;
    }

    /**
     * 通过传入id 查询用户实例
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Restful应用,返回通过token查询的用户实例
     * @param mixed $token
     * @param null $type
     * @return null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; //这里不是restful应用, 可以直接返回null
    }

    /**
     * 返回当前用户id
     * @return mixed
     */
    public  function getId(){
        return $this->userid;
    }

    public  function getAuthKey(){
        return '';
    }

    public  function validateAuthKey($authKey){
        return true;
    }
}
