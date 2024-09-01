<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Doctor;
use app\models\DoctorDetail;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login','signup'], // Allow access to login and signup for everyone
                        'allow' => true,
                        'roles' => ['?'], // Guest users
                    ],
                    [
                        'actions' => ['logout', 'index', 'contact', 'about', 'add-details'], // Restrict access to logout action
                        'allow' => true,
                        'roles' => ['@'], // Authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
        return $this->render('index');
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

        if ($model->load(Yii::$app->request->post())) {
            $role = Yii::$app->request->post('LoginForm')['role'];

            if ($role === 'user') {
                $userModel = User::findByUsername($model->username);
                Yii::$app->session->set('user_id', $userModel->id);
            } elseif ($role === 'doctor') {
                $userModel = Doctor::findByUsername($model->username);
            } else {
                $userModel = null;
            }

            Yii::$app->session->set('user_id', $userModel->id);

            if ($userModel && Yii::$app->security->validatePassword($model->password, $userModel->password)) {
                Yii::$app->user->login($userModel);

                $token = $userModel->generateJwtToken(); // Generate JWT token

                return $this->render('login', [
                    'model' => $model,
                    'token' => $token,
                    'role' => $role,
                ]);
            } else {
                $model->addError('password', 'Incorrect username or password.');
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionReact()
    {
        // Ensure the path correctly points to the built React index.html file
        return $this->renderPartial('@app/web/react/index.html');
    }


    public function actionSignup()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            // Hash the password before saving
            $model->password = Yii::$app->security->generatePasswordHash($model->password);

            // Get the role directly from the POST data
            $role = Yii::$app->request->post('role');

            if ($role === 'user') {
                // Save to the User table
                if ($model->save()) {
                    return $this->redirect(['site/login']);
                }
            } elseif ($role === 'doctor') {
                // Save to the Doctor table
                $doctorModel = new Doctor(); // Assuming you have a Doctor model
                $doctorModel->attributes = $model->attributes;
                if ($doctorModel->save()) {
                    return $this->redirect(['site/login']);
                }
            }
        }

        // Render the signup view with the model
        return $this->render('signup', [
            'model' => $model,
        ]);
    }




    public function actionAddDetails()
    {
        // Get the current logged-in doctor's ID
        $doctorId = Yii::$app->user->id;

        // Check if doctor details already exist
        $doctorDetail = DoctorDetail::findOne(['doctor_id' => $doctorId]);

        if ($doctorDetail === null) {
            $doctorDetail = new DoctorDetail();
            $doctorDetail->doctor_id = $doctorId;
        }

        if ($doctorDetail->load(Yii::$app->request->post()) && $doctorDetail->save()) {
            Yii::$app->session->setFlash('success', 'Doctor details saved successfully.');
            return $this->redirect(['react', 'id' => $doctorId]);
        }

        return $this->render('add-details', [
            'model' => $doctorDetail,
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
        return $this->redirect('site/login');
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


    public function actionDoctorList()
    {
        // Fetch the list of doctors with their details
        $doctors = Doctor::find()
            ->joinWith('doctorDetail') // Assuming 'doctorDetail' is the relation name
            ->asArray()
            ->all();

        // Prepare the response
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $doctors;
    }


}
