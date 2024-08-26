<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctor_detail".
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $specialization
 * @property int $experience_years
 * @property string $qualification
 * @property string $bio
 * @property int $consultation_fee
 * @property string $available_days
 * @property string $start_time
 * @property string $end_time
 *
 * @property Doctor $doctor
 */
class DoctorDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'specialization', 'experience_years', 'qualification', 'consultation_fee'], 'required'],
            [['doctor_id', 'experience_years', 'consultation_fee'], 'integer'],
            [['bio'], 'string'],
            [['available_days'], 'safe'],
            [['start_time', 'end_time'], 'string', 'max' => 5],
            [['specialization', 'qualification'], 'string', 'max' => 255],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::class, 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'specialization' => 'Specialization',
            'experience_years' => 'Experience Years',
            'qualification' => 'Qualification',
            'bio' => 'Bio',
            'consultation_fee' => 'Consultation Fee',
            'available_days' => 'Available Days',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
        ];
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Convert available_days array to string
            if (is_array($this->available_days)) {
                $this->available_days = implode(',', $this->available_days);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        // Convert available_days string back to array
        if (is_string($this->available_days)) {
            $this->available_days = explode(',', $this->available_days);
        }
    }



}
