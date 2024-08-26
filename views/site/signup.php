<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="<?= \Yii::getAlias('@web') ?>/css/site.css"> <!-- Link to your external CSS file -->
</head>

<body>
    <div class="container p-5" style="margin-top: 50px">
        <div class="row main">
            <!-- Left side -->
            <div id="login-left" class="col-md-6 p-5 d-flex flex-column justify-content-evenly align-items-center"
                style="background-color: #0bcc96;">
                <div class="mt-3" style="border-radius: 50px; width: 100px; height: 100px; overflow: hidden;">
                    <img src="<?= \Yii::getAlias('@web') ?>/images/Green-flame-580x386.jpg" alt="Design Spacee Logo"
                        style="width: 100%; height: 100%; object-fit: cover;" />
                </div>
                <h1 class="text-center text-white fw-bold mt-3">Join Our Healthcare Community</h1>
                <h2 class="text-center text-white">Empowering You with Comprehensive Health Solutions</h2>

                <button class="mt-5 w-50 fw-bold"
                    style="height: 40px; border-radius: 25px; border: none; color: #0bcc96; background-color: white;">Sign
                    Up</button>
                <h6 class="text-center text-white mt-5 mb-3">Rahul | Vishwakarma</h6>
            </div>

            <!-- Right side -->
            <div class="col-md-6 p-0" style="background-color: #0bcc96;">
                <div id="login-right" class="w-100 bg-white d-flex justify-content-center">
                    <div class="w-75 p-5 d-flex flex-column">
                        <h1 class="mt-2 text-center">Create Account</h1>
                        <p class="text-center mt-3">Fill in the details below to create your account</p>

                        <?php $form = ActiveForm::begin([
                            'id' => 'signup-form',
                            'action' => ['signup'],
                            'method' => 'post',
                            'fieldConfig' => [
                                'template' => "{input}\n{error}",
                                'inputOptions' => ['class' => 'form-control mt-4'],
                                'errorOptions' => ['class' => 'invalid-feedback'],
                            ],
                        ]); ?>

                        <!-- Role Selection -->
                        <div style="margin-bottom:10px;">
                            <label for="role">Sign up as:</label>
                            <select name="role" id="role" class="form-control w-100 mt-4">
                                <option value="">Select Role</option>
                                <option value="user">User</option>
                                <option value="doctor">Doctor</option>
                            </select>
                        </div>

                        <!-- Username -->
                        <div style="margin-bottom:10px;">
                            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Full Name', 'class' => 'form-control w-100 mt-4']) ?>
                        </div>

                        <!-- Email -->
                        <div style="margin-bottom:10px;">
                            <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Email', 'class' => 'form-control w-100 mt-4']) ?>
                        </div>

                        <!-- Password -->
                        <div style="margin-bottom:10px;">
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control w-100 mt-4']) ?>
                        </div>

                        <!-- Phone -->
                        <div style="margin-bottom:20px;">
                            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Phone', 'class' => 'form-control w-100 mt-4']) ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <?= Html::submitButton('Create Account', ['class' => 'mt-3 w-50 text-white fw-bold', 'style' => 'height: 40px; border-radius: 50px; background-color: #0bcc96; border: none;']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <!-- Login Link -->
                        <h6 class="mt-3 text-secondary text-center">
                            Already have an account?
                            <a href="<?= Yii::$app->urlManager->createUrl(['site/login']) ?>" class="fw-bold"
                                style="color:#0bcc96;">
                                Login
                            </a>
                        </h6>
                    </div>
                </div>
            </div>  
        </div>
    </div>

</body>

</html>
