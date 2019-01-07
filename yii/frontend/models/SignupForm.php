<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public  $confirmPassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required','message' => 'Укажите свой login.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой логин уже есть.'],
            ['username', 'string', 'max' => 12],


            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email', 'message'=>'Не правильный формат email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой email уже есть.'],

            ['password', 'required', 'message' => 'Укажите свой пароль.'],
           ['confirmPassword', 'required', 'message' => 'Укажите свой пароль.'],
            ['password', 'string', 'min' => 8 , 'max'=>16 , 'message'=>'Пароль должен содержать от 8 до 16 символов'],
        ];
    }
    public function attributeLabels()
    {
      return [
        'username'=>'Имя',
        'password'=>'Пароль',
        'confirmPassword'=>'GjlПароль',
        'email'=>'Email',

      ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        //$user->confirmPassword = $this->password;
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

//    public function Password($password,$attribute)
//    {
//      $confirmPassword = User::findOne(['password'=>$password]);
//
//      if (!$this->hasErrors()) {
//        if (!$confirmPassword === $password) {
//          $this->addError($attribute, 'Имя или пароль введены не правильно.');
//        }
//      }
//    }
}