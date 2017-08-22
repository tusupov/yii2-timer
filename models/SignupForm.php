<?php

namespace app\models;

use Yii,
    yii\base\Model;

class SignupForm extends Model {

    public $username;
    public $password;
    public $email;
    public $passwordConfirm;

    /**
     * Rules
     * @return array
     */
    public function rules() {

        return [
            [
                ['email', 'username'],
                'trim'
            ],
            [
                ['email', 'username', 'password', 'passwordConfirm'],
                'required'
            ],
            [
                ['email'],
                'email'
            ],
            [
                ['email'],
                'unique',
                'targetClass' => '\app\models\User',
                'message' => 'Этот почта уже существует.'
            ],
            [
                ['username'],
                'unique',
                'targetClass' => '\app\models\User',
                'message' => 'Этот логин уже существует.'
            ],
            [
                ['username'],
                'string',
                'min' => 6,
                'max' => 255
            ],
            [
                ['password', 'passwordConfirm'],
                'string',
                'min' => 6
            ],
            [
                ['passwordConfirm'],
                'compare',
                'compareAttribute' => 'password'
            ],
        ];

    }

    /**
     * Attribute Labels
     * @return array
     */
    public function attributeLabels() {

        return [
            "email"           => "E-mail",
            "username"        => "Логин",
            "password"        => "Пароль",
            "passwordConfirm" => "Повторите пароль",
        ];

    }

    /**
     * User Sign Up
     * @return User|null
     */
    public function signup(){

        if (!$this->validate())
            return null;

        $user = new User();

        $user->email    = $this->email;
        $user->username = $this->username;
        $user->setPassword($this->password);

        if ($user->save()) {

            Yii::$app->getSession()->set("login", $user->username);
            return $user;

        }

        return null;

    }

}
