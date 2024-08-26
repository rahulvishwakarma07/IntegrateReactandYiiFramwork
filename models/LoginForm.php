<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $role; // Add role property

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username, password, and role are all required
            [['username', 'password', 'role'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username, password, and role.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]] and [[role]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            // Use the role to find the user in the appropriate table
            if ($this->role === 'user') {
                $this->_user = User::findOne(['username' => $this->username]);
            } elseif ($this->role === 'doctor') {
                $this->_user = Doctor::findOne(['username' => $this->username]);
            }
        }

        return $this->_user;
    }
}
?>