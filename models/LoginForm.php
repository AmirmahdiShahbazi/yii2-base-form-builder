<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 * It is NOT an ActiveRecord (not saved to DB), but a form model.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * Validation Rules
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => '{attribute} نمی‌تواند خالی باشد.'],
            
            ['rememberMe', 'boolean'],
            
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'نام کاربری',
            'password' => 'رمز عبور',
            'rememberMe' => 'مرا به خاطر بسپار',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'نام کاربری یا رمز عبور اشتباه است.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}