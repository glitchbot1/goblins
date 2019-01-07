<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $role
 * @property string $email_confirm_token
 */
class User extends \yii\db\ActiveRecord
{

   const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','email', 'role','status'], 'required'],
//            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
//            [['status', 'created_at', 'updated_at'], 'integer'],
//            [['username', 'password_hash', 'password_reset_token', 'email', 'role', 'email_confirm_token'], 'string', 'max' => 255],
//            [['auth_key'], 'string', 'max' => 32],
//            [['email_confirm_token'], 'unique'],
            ['email', 'unique'],
//            [['password_reset_token'], 'unique'],
           ['username','unique'],
          ['role', 'integer'],
          ['status', 'string'],
        ];
    }

    public function scenarios()
    {
      $user = parent::scenarios();
      $user[self::SCENARIO_CREATE] = ['username','email', 'role','status',];
      return $user;
    }


  /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'role' => 'Role',
            'email_confirm_token' => 'Email Confirm Token',
        ];
    }
}
