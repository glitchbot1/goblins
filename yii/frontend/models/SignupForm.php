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
            ['username', 'required','message' => 'Укажите свой login,максимум 12 символов.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой логин уже есть.'],
            ['username', 'string', 'max' => 12],


            ['email', 'trim'],
            ['email', 'required','message' => 'Укажите свой email.'],
            ['email', 'email', 'message'=>'Не правильный формат почты'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой email уже есть.'],

            ['password','required', 'message' => 'Пароль должен содержать от 8 до 16 символов'],
            ['password', 'string', 'min' => 8 , 'max'=>16],


            ['confirmPassword','required', 'message' => 'Подтвердите пароль.'],
            ['confirmPassword', 'validatePassword'],
        ];
    }
    public function attributeLabels()
    {
      return [
        'username'=>'Имя',
        'password'=>'Пароль',
        'confirmPassword'=>'Подтверждение пароля',
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
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

    public function validatePassword($attribute,$params)
    {
      if(!$this->hasErrors())
      {
        if($this->password != $this->confirmPassword)
        {
          return $this->addError($attribute,'Пароли не свопадают');
        }

      }

    }

}
