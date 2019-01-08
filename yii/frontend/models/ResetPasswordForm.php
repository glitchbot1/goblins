<?php
namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;
    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Пустой токен.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Неверный токен сброса пароля.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password','required', 'message' => 'Пароль должен содержать от 8 до 16 символов'],
            ['password', 'string', 'min' => 8, 'max'=>16],

            ['confirmPassword','required', 'message' => 'Подтвердите пароль.'],
            ['confirmPassword','validatePassword'],
        ];
    }

    public function attributeLabels()
    {
      return [

        'password' => 'Пароль',
         'confirmPassword' => 'Подтверждение пароля',

      ];
    }

  /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    public function validatePassword($attribute,$params)
    {
      if (!$this->hasErrors())
      {
        if ($this->password != $this->confirmPassword)
        {
          return $this->addError($attribute,'Пароли не совпадают');
        }

      }
    }
}
