<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

<?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

<!--    --><?//= $form->field($model, 'auth_key') ?>
<!---->
<!--    --><?//= $form->field($model, 'password_hash') ?>
<!---->
<!--    --><?//= $form->field($model, 'password_reset_token') ?>

    <?php  echo $form->field($model, 'email') ?>

    <?php  echo $form->field($model, 'status') ?>

<!--    --><?php // echo $form->field($model, 'created_at') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'updated_at') ?>

<!--    --><?php // echo $form->field($model, 'email_confirm_token') ?>

    <?php  echo $form->field($model, 'role') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Отмена', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
