<?php

namespace common\services\auth;

use Yii;
use common\models\User;
use frontend\models\SignupForm;

class SignupService
{

  public function signup(SignupForm $form)
  {
    $user = new User();
    $user->username = $form->username;
    $user->generateAuthKey();
    $user->setPassword($form->password);
    $user->setPassword($form->confirmPassword);
    $user->email = $form->email;
    $user->email_confirm_token = Yii::$app->security->generateRandomString();
    $user->status = User::STATUS_WAIT;

    if(!$user->save()){
      throw new \RuntimeException('Ошибка при сохранении.');
    }

    return $user;
  }




  public function sentEmailConfirm(User $user)
  {
    $email = $user->email;

    $sent = Yii::$app->mailer
      ->compose(
        ['html' => 'user-signup-comfirm-html', 'text' => 'user-signup-comfirm-text'],
        ['user' => $user])
      ->setTo($email)
      ->setFrom('asdjkfsdf1Q@mail.ru')
      ->setSubject('Подтвердите свою регистрацию')
      ->send();

    if (!$sent) {
      throw new \RuntimeException('Ошибка при отправки письма.');
    }
  }


  public function confirmation($token)
  {
    if (empty($token)) {
      throw new \DomainException('Пустой токен подтверждения.');
    }

    $user = User::findOne(['email_confirm_token' => $token]);
    if (!$user) {
      throw new \DomainException('Пользователь не найден.');
    }

    $user->email_confirm_token = null;
    $user->status = User::STATUS_ACTIVE;
    if (!$user->save()) {
      throw new \RuntimeException('Ошибка при сохранении.');
    }

    if (!Yii::$app->getUser()->login($user)){
      throw new \RuntimeException('Ошибка авторизации.');
    }
  }

}