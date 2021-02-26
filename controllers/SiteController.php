<?php

namespace app\controllers;

use app\models\TestResults;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
     * @return string
     */
    public function actionIndex()
    {
        $db = Yii::$app->db->getIsActive();
        var_dump($db);
        return $this->render('index');
    }

    /**
     * Displays upload form
     * @return string
     */
    public function actionUpload()
    {
        $model = new UploadForm();
        $badRows = [];
        $goodRows = [];

        if(Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if($model->process()) {
                $handle = fopen($model->csvFile->tempName, "r");
                $firstRowFlag = true;

                while (($data = fgetcsv($handle, 1000, ",")) !== false)
                {
                    if($firstRowFlag) {
                        $firstRowFlag = false;
                        continue;
                    }
                    $testTaker = $data[1] ?? '';
                    $correctAnswer = $data[2] ?? 0;
                    $incorrectAnswer = $data[3] ?? 0;
                    if($testTaker && $correctAnswer && $incorrectAnswer){
                        $testResults = new TestResults();
                        $testResults->test_taker = $testTaker;
                        $testResults->correct_answers = $correctAnswer;
                        $testResults->incorrect_answers = $incorrectAnswer;
                        if($testResults->save()) {
                            $goodRows[] = $testTaker;
                        } else {
                            if($testResults->getErrors('test_taker')) {
                                $badRows[] = $testTaker;
                            }
                        }
                    }
                }
                if(!$badRows) {
                    Yii::$app->session->setFlash('fileSuccessfullyProcessed', count($goodRows));
                } else {
                    Yii::$app->session->setFlash('fileNotSuccessfullyProcessed', [
                        'good' => count($goodRows),
                        'bad' => implode(', ', $badRows),
                        'badCount' => count($badRows)
                    ]);
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
    public function actionList()
    {


        return $this->render('list', [
//            'model' => $model,
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
    public function actionLogout()
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
    public function actionAbout()
    {
        return $this->render('about');
    }
}
