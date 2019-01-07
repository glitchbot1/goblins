<?php

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-confirm', 'token' => $user->email_confirm_token]);
?>
  Привет <?= $user->username ?>,

  Пройдите по ссылке для подтверждения регистрации:<?= $confirmLink ?>