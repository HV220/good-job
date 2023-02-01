<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\LoginForm;
use common\models\RegistrationForm;
use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use yii2mod\rbac\filters\AccessControl;

/**
 * SiteController class
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['registration', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return array[]
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(array('contact/index'));
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(array('contact/index'));
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return Response|string
     */
    public function actionRegistration(): Response|string
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно.');
            return Yii::$app->response->redirect(['contact/index']);
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }
}
