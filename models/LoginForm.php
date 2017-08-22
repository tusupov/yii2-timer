<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * Rules
     * @return array
     */
    public function rules()
    {

        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];

    }

    /**
     * Attribute Labels
     * @return array
     */
    public function attributeLabels()
    {

        return [
            'username'   => 'Логин',
            'password'   => 'Пароль',
            'rememberMe' => 'Запомни меня'
        ];

    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {

        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password))
                $this->addError($attribute, 'Неверный логин или пароль.');

        }

    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {

        $user = $this->getUser();

        if ($this->validate() && Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0)) {

            $user->lastlogin_at = time();
            $user->save();

            Yii::$app->getSession()->set("login", $this->getUser()->username);

            return true;

        }

        return false;

    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {

        return User::findOne([
            'username' => $this->username
        ]);

    }

}
