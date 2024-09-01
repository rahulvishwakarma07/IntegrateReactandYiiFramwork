<?php
namespace app\controllers;

use app\models\User;
use Yii;
use yii\rest\Controller;
use app\models\Doctor;
use app\models\DoctorDetail;
use yii\web\Response;

class DoctorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['http://localhost:5173'], // Allows requests from any origin
                    'Access-Control-Request-Method' => ['*'], // Allows all methods
                    'Access-Control-Request-Headers' => ['*'], // Allows all headers
                    'Access-Control-Allow-Credentials' => true,
                ],
            ],
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],  
        ];
    }

    /**
     * Lists all doctors with their details.
     * @return array
     */
    public function actionIndex()
    {
        $doctors = Doctor::find()->all();
        $doctorList = [];

        foreach ($doctors as $doctor) {
            $doctorDetails = DoctorDetail::find()->where(['doctor_id' => $doctor->id])->one();
            $doctorList[] = [
                'id' => $doctor->id,
                'username' => $doctor->username,
                'email' => $doctor->email,
                'phone' => $doctor->phone,
                'specialization' => $doctorDetails ? $doctorDetails->specialization : null,
                'experience_years' => $doctorDetails ? $doctorDetails->experience_years : null,
                'qualification' => $doctorDetails ? $doctorDetails->qualification : null,
                'bio' => $doctorDetails ? $doctorDetails->bio : null,
                'consultation_fee' => $doctorDetails ? $doctorDetails->consultation_fee : null,
                'available_days' => $doctorDetails ? $doctorDetails->available_days : null,
                'start_time' => $doctorDetails ? $doctorDetails->start_time : null,
                'end_time' => $doctorDetails ? $doctorDetails->end_time : null,
            ];
        }

        return $doctorList;
    }

    public function actionDoctor($id)
{
    // Find the doctor by ID
    $doctor = Doctor::find()->where(['id' => $id])->one();

    // Check if the doctor exists
    if ($doctor) {
        // Fetch doctor details
        $doctorDetails = DoctorDetail::find()->where(['doctor_id' => $doctor->id])->one();

        // Build the doctor list array for a single doctor
        $doctorList = [
            'id' => $doctor->id,
            'username' => $doctor->username,
            'email' => $doctor->email,
            'phone' => $doctor->phone,
            'specialization' => $doctorDetails ? $doctorDetails->specialization : null,
            'experience_years' => $doctorDetails ? $doctorDetails->experience_years : null,
            'qualification' => $doctorDetails ? $doctorDetails->qualification : null,
            'bio' => $doctorDetails ? $doctorDetails->bio : null,
            'consultation_fee' => $doctorDetails ? $doctorDetails->consultation_fee : null,
            'available_days' => $doctorDetails ? $doctorDetails->available_days : null,
            'start_time' => $doctorDetails ? $doctorDetails->start_time : null,
            'end_time' => $doctorDetails ? $doctorDetails->end_time : null,
        ];

        return $doctorList;
    } else {
        // Return an appropriate response if no doctor is found
        return [
            'error' => 'Doctor not found',
            'message' => 'The doctor with the specified ID does not exist.'
        ];
    }
}


    public function actionCount()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Count the number of users
        $userCount = User::find()->count();

        // Count the number of doctors
        $doctorCount = Doctor::find()->count();

        // Return the counts as a JSON response
        return [
            'user_count' => $userCount,
            'doctor_count' => $doctorCount,
        ];
    }
}
