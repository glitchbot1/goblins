<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\services\auth\SignupService;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $form = new LoginForm();
    if ($form->load(Yii::$app->request->post())) {
      try{
        if($form->login()){
          return $this->goBack();
        }
      } catch (\DomainException $e){
        Yii::$app->session->setFlash('error', $e->getMessage());
        return $this->goHome();
      }
    }

    return $this->render('login', [
      'model' => $form,
    ]);
  }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['asdjkfsdf1Q@mail.ru'])) {
                Yii::$app->session->setFlash('success', 'Спасибо,за ваше соообщение.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    //регистрация
    public function actionSignup()
    {
      $form = new SignupForm();
      if ($form->load(Yii::$app->request->post()) && $form->validate()) {

        $signupService = new SignupService();
        try{
          $user = $signupService->signup($form);
          Yii::$app->session->setFlash('success', 'Проверьте свой email для подтверждения регистарции.');
          $signupService->sentEmailConfirm($user);
          return $this->goHome();
        } catch (\RuntimeException $e){
          Yii::$app->errorHandler->logException($e);
          Yii::$app->session->setFlash('error', $e->getMessage());
        }
      }

      return $this->render('signup', [
        'model' => $form,
      ]);
    }

    public function actionSignupConfirm($token)
    {
      $signupService = new SignupService();

      try{
        $signupService->confirmation($token);
        Yii::$app->session->setFlash('success', 'Вы успешно подтвердили свою регистрацию.');
      } catch (\Exception $e){
        Yii::$app->errorHandler->logException($e);
        Yii::$app->session->setFlash('error', $e->getMessage());
      }

      return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту .');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
