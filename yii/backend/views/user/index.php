<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use  yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

      <h1><?= Html::encode($this->title) ?></h1>
   <?php Pjax::begin(); ?>

<!--    --><?php //Modal::begin([
//
//    'header' => '<h2>Поиск</h2>',
//    'toggleButton' => ['label' => 'Поиск','class'=>'btn btn danger'],
//    'footer' => '=:)',
//    ]); ?>
<!--    --><?//=  $this->render('_search', ['model' => $searchModel]); ?>
<!---->
<!--    --><?php //Modal::end();?>


    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            //'auth_key',
           // 'password_hash',
            //'password_reset_token',
            'email:email',
            'status',
              ['attribute'=>'created_at','format'=>'date'],
            ['attribute'=>'updated_at','format'=>'date'],
            //'email_confirm_token:email',
            'role',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
