<?php
// models/Doctor.php
namespace app\models;

use Firebase\JWT\JWT;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Doctor extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'phone'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => '\app\models\Doctor', 'message' => 'This email address has already been taken.'],
            [['username'], 'unique', 'targetClass' => '\app\models\Doctor', 'message' => 'This username has already been taken.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
        ];
    }

    /**
     * Generates a hashed password from the given password.
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates the password.
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates a unique authentication key.
     */


    /**
     * Finds a doctor by ID.
     * @param int|string $id
     * @return static|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds a doctor by auth key.
     * @param string $token
     * @return static|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds a doctor by email.
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Gets the ID of the doctor.
     * @return int|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Gets the auth key.
     * @return string
     */
    public function getAuthKey()
    {
        // return $this->auth_key;
    }

    /**
     * Validates the auth key.
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        // return $this->getAuthKey() === $authKey;
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


}
?>