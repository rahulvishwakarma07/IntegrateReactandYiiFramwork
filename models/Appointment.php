<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointment".
 *
 * @property int $ID
 * @property int|null $user_id
 * @property int|null $doctor_id
 * @property string|null $appointment_date
 * @property string|null $appointment_time
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'doctor_id'], 'integer'],
            [['appointment_date'], 'date', 'format' => 'php:Y-m-d'],
            // [['appointment_time'], 'string', 'format' => ''],
            [['status'], 'in', 'range' => ['Pending', 'Confirmed', 'Cancelled', 'Completed']],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'doctor_id', 'appointment_date', 'appointment_time', 'status'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'user_id' => 'User ID',
            'doctor_id' => 'Doctor ID',
            'appointment_date' => 'Appointment Date',
            'appointment_time' => 'Appointment Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Doctor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
    }
}
