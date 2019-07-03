<?php

namespace common\models;

use yii\base\Model;

/**
 * Class SignupForm
 * Регистрация новых пользователей
 * @package common\models
 */
class SignupForm extends Model
{
    /** @var string Логин пользователя */
    public $username;
    /** @var string Email пользователя */
    public $email;
    /** @var string Пароль пользователя */
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This username has already been taken.'
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This email address has already been taken.'
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Регистрирует нового пользователя
     *
     * @return bool whether the creating new account was successful
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $res = $user->save();

        if ($res) {
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole(Rbac::ROLE_USER);
            $auth->assign($role, $user->id);
        }

        return $res;
    }
}
