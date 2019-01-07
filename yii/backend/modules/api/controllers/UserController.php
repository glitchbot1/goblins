<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\User;

class UserController extends \yii\web\Controller
{
  public $enableCsrfValidation = false;


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListUser() {
      //получить ответ в формате json
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      //нашли всех пользователей в бд
      $user = User::find()->all();
        if (count($user)>0)
        {
          return array('status'=>true,'user'=>$user);
        }
        else{
          return array('status'=>false,'user'=>'No user');
        }

    }

    public function actionCreateUser() {

      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $user = new User();
      $user->scenario = User::SCENARIO_CREATE;
      $user->attributes = \Yii::$app->request->post();

      if ($user->validate()) {

        $user->save();
        return array('status' => true, 'data' => 'Successfully');
      }
      else {

        return array('status'=>false,'user'=>$user->getErrors());
      }

    }


}
