<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class UserController extends Controller
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

    public function actionLogout()
    {
        if (Yii::$app->user->logout()) {
            return "Logout Successfully";
        }
        return "Logout Failed";
    }

    public function actionUpdate($id)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Find the user by ID
        $model = User::findOne($id);

        // If the user does not exist, return an error response
        if (!$model) {
            return [
                'status' => false,
                'message' => 'User not found.',
            ];
        }

        // Load the data from the request
        $data = \Yii::$app->request->post();

        // Assign the data to the model attributes
        $model->username = $data['username'] ?? $model->username;
        $model->email = $data['email'] ?? $model->email;
        $model->phone = $data['phone'] ?? $model->phone;

        // Validate and save the updated model
        if ($model->validate() && $model->save()) {
            return [
                'status' => true,
                'message' => 'User details updated successfully.',
            ];
        }

        // If validation or save failed, return error messages
        return [
            'status' => false,
            'message' => 'Failed to update user details.',
            'errors' => $model->errors,
        ];
    }

    public function actionGetUser($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Find the user by ID
        $model = User::findOne($id);

        // If the user does not exist, return an error response
        if (!$model) {
            return [
                'status' => false,
                'message' => 'User not found.',
            ];
        }

        // Return the user data as a JSON response
        return [
            'status' => true,
            'data' => [
                'id' => $model->id,
                'username' => $model->username,
                'email' => $model->email,
                'phone' => $model->phone,
                // Add other fields as needed
            ],
        ];
    }


    public function actionUpdatePassword($id)
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    // Find the user by ID
    $model = User::findOne($id);

    // If the user does not exist, return an error response
    if (!$model) {
        return [
            'status' => false,
            'message' => 'User not found.',
        ];
    }

    // Load the data from the request
    $data = \Yii::$app->request->post();

    // Check if both old and new passwords are provided
    if (empty($data['old_password']) || empty($data['new_password'])) {
        return [
            'status' => false,
            'message' => 'Old password and new password are required.',
        ];
    }

    // Verify the old password
    if (!Yii::$app->getSecurity()->validatePassword($data['old_password'], $model->password_hash)) {
        return [
            'status' => false,
            'message' => 'Incorrect old password.',
        ];
    }

    // Hash the new password
    $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($data['new_password']);

    // Save the updated model
    if ($model->save()) {
        return [
            'status' => true,
            'message' => 'Password updated successfully.',
        ];
    }

    // If saving failed, return error messages
    return [
        'status' => false,
        'message' => 'Failed to update password.',
        'errors' => $model->errors,
    ];
}



}
