<?php
namespace app\controllers;

use app\models\Appointment;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class AppointmentController extends Controller
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

    public function actionBookAppointment()
    {
        $appointment = new Appointment();

        // Attempt to load data directly from POST request without nesting
        if ($appointment->load(Yii::$app->request->post(), '')) {
            // Check if validation passes
            if ($appointment->validate()) {
                if ($appointment->save()) {
                    return "Booking Successfully";
                } else {
                    return "Internal Server Error";
                }
            } else {
                // Output validation errors for debugging
                return json_encode($appointment->errors);
            }
        } else {
            // Output message if data loading failed
            return "Failed to load data from POST request";
        }
    }

    public function actionUserAppointment($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Fetch appointments for a specific user, including related user and doctor information
        $appointments = Appointment::find()
            ->where(['user_id' => $id])
            ->with('user', 'doctor')
            ->all();

        // Prepare the result with detailed user and doctor information
        $result = [];
        foreach ($appointments as $appointment) {
            $result[] = [
                'id' => $appointment->ID,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'status' => $appointment->status,
                'created_at' => $appointment->created_at,
                'updated_at' => $appointment->updated_at,
                'user' => $appointment->user ? [
                    'id' => $appointment->user->id,
                    'username' => $appointment->user->username, // Replace with actual user fields
                    'email' => $appointment->user->email, // Replace with actual user fields
                    'phone' => $appointment->user->phone,
                    // Add other user fields as needed
                ] : null,
                'doctor' => $appointment->doctor ? [
                    'id' => $appointment->doctor->id,
                    'username' => $appointment->doctor->username, // Replace with actual doctor fields
                    'email' => $appointment->doctor->email, // Replace with actual doctor fields
                    'phone' => $appointment->doctor->phone,
                    // Add other doctor fields as needed
                ] : null,
            ];
        }

        return $result;
    }



}
