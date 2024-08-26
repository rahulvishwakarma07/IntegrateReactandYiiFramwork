<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DoctorDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-detail-form " style="margin-top: 100px;">
    <?php $form = ActiveForm::begin([
        'id' => 'doctor-detail-form',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

    <div class="row " >
        <div class="col-md-6">

            <?= $form->field($model, 'specialization')->dropDownList([
                'General Practitioner' => 'General Practitioner',
                'Cardiologist' => 'Cardiologist',
                'Dermatologist' => 'Dermatologist',
                'Pediatrician' => 'Pediatrician',
                'Neurologist' => 'Neurologist',
            ], ['prompt' => 'Select Specialization']) ?>

            <?= $form->field($model, 'experience_years')->textInput(['type' => 'number']) ?>

            <?= $form->field($model, 'qualification')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'bio')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'consultation_fee')->textInput(['type' => 'number']) ?>

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

        <div class="col-md-6">
            <?= $form->field($model, 'start_time')->input('time', ['class' => 'form-control']) ?>
            <?= $form->field($model, 'end_time')->input('time', ['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
    .doctor-detail-form {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .doctor-detail-form .form-group {
        margin-bottom: 20px;
    }

    .doctor-detail-form label {
        font-weight: bold;
    }

    .doctor-detail-form .btn-success {
        width: 100%;
        padding: 10px;
        font-size: 18px;
    }

    .doctor-detail-form .help-block {
        color: #dc3545;
    }
</style>
