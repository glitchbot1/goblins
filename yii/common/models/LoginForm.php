<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;


/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required','message'=>'Укажите свое имя пожалуйсто'],
            [ ['password'], 'required','message'=>'Укажите свой пароль пожалуйсто'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    public function attributeLabels()
    {
      return [
        'username'=>'Имя',
         'password'=>'Пароль',
      ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Имя или пароль введены не правильно.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    //авторизация админа
    public function loginAdmin() {

      if ($this->validate() && User::isAdmin($this->username)) {
        return Yii::$app->user->login($this->getUser());
      }
      if (!User::isAdmin($this->username)) {
        throw new ForbiddenHttpException('Доступ запрещен');
      }

    }


  public function login()
  {
    if ($this->validate()) {

      $user = $this->getUser();
      if($user->status === User::STATUS_ACTIVE){
        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
      }
      if($user->status === User::STATUS_WAIT){
        throw new \DomainException('Для полный регистрации зайдите на почту и пройдите по ссылке.');
      }

    } else {
      return false;
    }
  }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
