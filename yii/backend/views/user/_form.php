<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'id') ?>

  <?= $form->field($model, 'username') ?>

<!--  --><?//= $form->field($model, 'auth_key') ?>

<!--  --><?//= $form->field($model, 'password_hash') ?>
<!--  --><?//= $form->field($model, 'password_reset_token') ?>

  <?= $form->field($model, 'email') ?>

  <?= $form->field($model, 'status') ?>

  <?= $form->field($model, 'created_at') ?>

  <?= $form->field($model, 'updated_at') ?>

  <?= $form->field($model, 'role') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
