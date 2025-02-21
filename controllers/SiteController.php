<?php

namespace app\controllers;

use app\models\TestResults;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use app\components\Helper;
use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
     * {@inheritdoc}
     */
    public function actions(): array
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
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * @return string|Response
     */
    public function actionUpload()
    {
        $model = new UploadForm();

        if(Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if($model->process()) {
                $handle = fopen($model->csvFile->tempName, "r");
                if($handle) {
                    $result = Helper::dataProcessor($handle);
                    $goodRows = $result['goodRows'];
                    $badRows = $result['badRows'];
                    if(!$badRows) {
                        Yii::$app->session->setFlash('fileSuccessfullyProcessed', count($goodRows));
                    } else {
                        Yii::$app->session->setFlash('fileNotSuccessfullyProcessed', [
                            'good' => count($goodRows),
                            'bad' => implode(', ', $badRows),
                            'badCount' => count($badRows)
                        ]);
                    }
                }

                return $this->refresh();
            }
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }

    /**
     * Displays grid
     * @return string
     */
    public function actionList(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TestResults::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $id
     * @return bool[]|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = TestResults::findOne($id);

        $model->delete();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        return $this->redirect(['index']);
    }

    /**
     * @return array|bool[]|string
     */
    public function actionCreate()
    {
        $model = new TestResults();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(!isset(Yii::$app->request->post()['ajax'])) {
                $model->save();
                return ['success' => true];
            }
            return ActiveForm::validate($model);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'type' => 'create'
            ]);
        }
    }

    /**
     * @param $id
     * @return array|bool[]|string
     */
    public function actionUpdate($id)
    {
        $model = TestResults::findOne($id);
        if ($model->load(Yii::$app->request->post())  ) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(!isset(Yii::$app->request->post()['ajax'])) {
                $model->save();
                return ['success' => true];
            }
            return ActiveForm::validate($model);
        }
        return $this->renderAjax('_form', [
            'model' => $model,
            'type' => 'update'
        ]);
    }

    /**
     * @return string
     */
    public function actionChart(): string
    {
        $query = (new Query())->from('test_results');
        $sum_correct = $query->sum('correct_answers');
        $sum_incorrect = $query->sum('incorrect_answers');
        $avg_correct = $query->average('correct_answers');
        $avg_incorrect = $query->average('incorrect_answers');

        return $this->render('chart', [
            'sum_correct' => $sum_correct,
            'sum_incorrect' => $sum_incorrect,
            'avg_correct' => $avg_correct,
            'avg_incorrect' => $avg_incorrect,
        ]);
    }

    /**
     * @return string
     */
    public function actionChartTwo(): string
    {
        $data = TestResults::find()->orderBy('id DESC')->limit(25)->all();

        return $this->render('chart_two', [
            'data' => $data
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }
}
