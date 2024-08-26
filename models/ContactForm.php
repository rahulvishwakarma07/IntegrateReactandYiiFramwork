<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $phone;  // Added phone property

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject, body, and phone are required
            [['name', 'email', 'subject', 'body', 'phone'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // phone should be a valid phone number (you can customize the regex as needed)
            ['phone', 'match', 'pattern' => '/^\+?[0-9]*$/', 'message' => 'Please enter a valid phone number.'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
            'phone' => 'Phone Number',  // Added phone label
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            // Compose email with phone number included
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody("Name: {$this->name}\nEmail: {$this->email}\nPhone: {$this->phone}\n\n{$this->body}")
                ->send();

            return true;
        }
        return false;
    }
}
