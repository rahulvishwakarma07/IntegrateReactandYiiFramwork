<?php

namespace app\models;

use Firebase\JWT\JWT;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $phone
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}'; // Assuming your table is named 'user'
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'phone'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20], // Adjust the length based on your needs
            [['password'], 'string', 'max' => 64],
            ['username', 'unique'],
            ['email', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password Hash'),
            'phone' => Yii::t('app', 'Phone'),
        ];
    }


   public function generateJwtToken()
    {
        $key = Yii::$app->params['jwtSecretKey']; // Store this key securely
        $payload = [
            'iat' => time(), // Issued at
            'exp' => time() + 3600, // Token expiration time
            'sub' => $this->id, // User ID
            
        ];

        $algorithm = 'HS256'; // Specify the algorithm to use

        return JWT::encode($payload, $key, $algorithm);
    }
    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return static|null the identity object that matches the given ID. Null if the identity is not found
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    public function getAppointments()
    {
        return $this->hasMany(Appointment::class, ['user_id' => 'id']);
    }


    /**
     * Finds an identity by the given token.
     * @param string $token the token to be looked for
     * @return static|null the identity object that matches the given token. Null if the identity is not found
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new \yii\base\NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Returns the ID of the user.
     * @return int|string the ID of the user
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the authentication key for the user.
     * @return string the authentication key
     */
    public function getAuthKey()
    {
        
        // throw new \yii\base\NotSupportedException('"getAuthKey" is not implemented.');
    }

    /**
     * Validates the given authentication key.
     * @param string $authKey the authentication key to be validated
     * @return bool whether the given authentication key is valid
     */
    public function validateAuthKey($authKey)
    {
        throw new \yii\base\NotSupportedException('"validateAuthKey" is not implemented.');
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
