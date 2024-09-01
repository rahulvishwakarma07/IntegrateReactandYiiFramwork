<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DoctorDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-detail-form container mb-3" style="margin-top : 100px;">
    <div class="row">
        <div class="col-md-5 p-4 d-flex flex-column align-items-center justify-content-center" id="image-color" style="border-radius: 8px" >
        <img src="<?= \Yii::getAlias('@web') ?>/images/5ba1a398ac0aa7fe01480166fd2b818f-removebg-preview.png"  alt="Design Spacee Logo" class="img-fluid"/>
        <p class="text-center text-white w-75 mt-3 fw-bold">This doctor's details are verified. For more information, please contact us.</p>
        </div>
        <div class="col-md-7 p-4">

            <?php $form = ActiveForm::begin([
                'id' => 'doctor-detail-form',
                'options' => ['class' => 'form-horizontal '],
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'specialization')->dropDownList([
                        'General Practitioner' => 'General Practitioner',
                        'Cardiologist' => 'Cardiologist',
                        'Dermatologist' => 'Dermatologist',
                        'Pediatrician' => 'Pediatrician',
                        'Neurologist' => 'Neurologist',
                    ], ['prompt' => 'Select Specialization']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'experience_years')->textInput(['type' => 'number']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'qualification')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'consultation_fee')->textInput(['type' => 'number']) ?>
                </div>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'bio')->textarea(['rows' => 6]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'available_days')->checkboxList([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ]) ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'start_time')->input('time') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'end_time')->input('time') ?>
                </div>
            </div>

            <div class="form-group mt-3">
                <?= Html::submitButton('Save', ['class' => 'w-100 button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<style>
    .doctor-detail-form {
        /* margin: 0 auto; */
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 8px 8px rgba(0, 0, 0, 0.1);
    }

    .doctor-detail-form .form-group {
        /* margin-bottom: 20px; */
    }

    .doctor-detail-form label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    /* .doctor-detail-form .btn-primary {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 4px;
        color: #ffffff;
        text-transform: uppercase;
        font-weight: bold;
    } */

    .doctor-detail-form .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .doctor-detail-form .help-block {
        color: #dc3545;
    }

    .doctor-detail-form .form-control {
        border-radius: 4px;
    }
    #image-color{
        background: linear-gradient(to right, #26f2b8, #6185e8,#a4dbcb);
    }
    .button{
        border: none;
        height: 40px;
        border-radius: 8px;
        background: linear-gradient(to right, #26f2b8, #707de0);
        font-weight: 600;
        color: white;
        font-size: 18px;

    }
</style>