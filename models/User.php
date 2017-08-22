<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $lastlogin_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * User table name
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Behaviors
     * @return array
     */
    public function behaviors()
    {

        return [
            TimestampBehavior::class
        ];

    }

    /**
     * Rules
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['email', 'username', 'password'],
                'required'
            ],
            [
                ['created_at', 'updated_at', 'lastlogin_at'],
                'integer'
            ],
            [
                ['email', 'username', 'password', 'auth_key'],
                'string',
                'max' => 255
            ],
            [
                ['email', 'username'],
                'unique'
            ],
        ];
    }

    /**
     * Attribute Labels
     * @return array
     */
    public function attributeLabels()
    {

        return [
            'id'           => 'ID',
            'email'        => 'E-mail',
            'username'     => 'Логин',
            'password'     => 'Пароль',
            'auth_key'     => 'Auth Key',
            'created_at'   => 'Время создания',
            'updated_at'   => 'Время изменение',
            'lastlogin_at' => 'Время последнего входа',
        ];

    }

    /**
     * Before Save
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord)
                $this->auth_key = Yii::$app->security->generateRandomString();

            return true;

        }

        return false;

    }

    /**
     * Find Identity
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
        ]);
    }

    /**
     * Find Identity by Access Token
     * @param mixed $token
     * @param null $type
     * @return bool
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Auth key
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this['auth_key'];
    }

    /**
     * Validate Auth key
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this['auth_key'] === $authKey;
    }

    /**
     * Validate Password
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this['password']);
    }

    /**
     * Set Password with Security Hash
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

}
