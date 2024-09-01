<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */
/** @var string|null $token */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<div class="container" style="margin-top : 100px">
    <div class="row main">
        <!-- Left side -->
        <div id="login-left" class="col-md-6 p-5 d-flex flex-column justify-content-evenly align-items-center"
            style="background-color: #0bcc96;">
            <div class="mt-3" style="border-radius: 50px; width: 100px; height: 100px; overflow: hidden;">
                <img src="<?= \Yii::getAlias('@web') ?>/images/Green-flame-580x386.jpg" alt="Design Spacee Logo"
                    style="width: 100%; height: 100%; object-fit: cover;" />
            </div>
            <h1 class="text-center text-white fw-bold mt-3">Welcome Back!</h1>
            <p class="text-center text-white">To stay connected with us<br>please login with your personal info</p>
            <button class="mt-5 w-50 fw-bold"
                style="height: 40px; border-radius: 25px; border: none; color: #0bcc96; background-color: white;">Sign
                In</button>
            <h6 class="text-center text-white mt-5 mb-3">Rahul | Vishwakarma</h6>
        </div>

        <!-- Right side -->
        <div class="col-md-6 p-0" style="background-color: #0bcc96">
            <div id="login-right" class="w-100 bg-white d-flex justify-content-center">
                <div class="w-75 p-5 d-flex  flex-column ">
                    <h1 class="mt-5 text-center">Welcome Back!</h1>
                    <p class="text-center mt-3">Login to your account to continue</p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{input}\n{error}",
                            'inputOptions' => ['class' => 'form-control mt-4 '],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <!-- Role Selection -->
                    <?= $form->field($model, 'role')->dropDownList(
                        ['user' => 'User', 'doctor' => 'Doctor'],
                        ['prompt' => 'Select Role', 'class' => 'form-control w-100 mt-4 ']
                    ) ?>

                    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username', 'class' => 'form-control w-100 mt-4 ']) ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control w-100 mt-4 ']) ?>

                    <small class="mt-3 ">Forget Password?</small>
                    <div class="text-center">
                        <?= Html::submitButton('Log In', ['class' => 'mt-5 w-50 text-white fw-bold', 'style' => 'height: 40px; border-radius: 50px; background-color: #0bcc96; border: none;']) ?>
                    </div>
                    <h6 class="mt-3 text-secondary text-center">
                        Don't have an account?
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/signup']) ?>" class="fw-bold"
                            style="color:#0bcc96;">
                            Signup
                        </a>
                    </h6>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($token)): ?>
    <script>
        // Store token in sessionStorage
        sessionStorage.setItem('authToken', <?= json_encode($token) ?>);
        
        // Store user/doctor ID in sessionStorage
        sessionStorage.setItem('userId', <?= json_encode(Yii::$app->session->get('user_id')) ?>);

        // Check the role and redirect accordingly
        const role = <?= json_encode($role) ?>;
        if (role === 'doctor') {
            window.location.href = '<?= \yii\helpers\Url::to(['site/add-details']) ?>';
        } else {
            window.location.href = '<?= \yii\helpers\Url::to(['site/index']) ?>';
        }
    </script>
<?php endif; ?>