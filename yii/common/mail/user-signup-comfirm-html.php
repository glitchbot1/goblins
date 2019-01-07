<?php
use yii\helpers\Html;



$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Привет <?= Html::encode($user->username) ?>,</p>

    <p>Пройдите по ссылке для подтверждения регистрации:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>