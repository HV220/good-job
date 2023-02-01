<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\Contact;
use common\models\ContactSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2mod\rbac\filters\AccessControl;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'roles' => ['contact/index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['view'],
                        'roles' => ['contact/view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'roles' => ['contact/create'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['update'],
                        'roles' => ['contact/update'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['delete'],
                        'roles' => ['contact/delete'],
                        'allow' => true,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all Contact models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return Contact|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?Contact
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string|Response
     */
    public function actionCreate(): Response|string
    {
        $model = new Contact();
        $model->user_id = Yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->cache->get($model->user_id . '_contact_create')) {
                Yii::$app->cache->set($model->user_id . '_contact_create', true, 60 * 60 * 24);

                if (!$model->upload() || !$model->save()) {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла');
                    return $this->redirect('index');
                }

                Yii::$app->session->setFlash('success', 'Сообщение успешно отправлено.');

                return $this->redirect('index');
            }

            Yii::$app->session->setFlash('error', 'Создавать сообщение можно раз в 24 часа.');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): Response|string
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
