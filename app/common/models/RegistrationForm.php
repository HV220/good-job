<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\base\Model;

/**
 *
 * @property string $username Электронная почта
 * @property string $email Ключ аунтификации
 * @property string $password Имя
 *
 * @property-read string $authKey
 */
class RegistrationForm extends Model
{

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [

            ['email', 'trim'],
            ['username', 'required'],
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
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function registration(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = User::STATUS_ACTIVE;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $auth = Yii::$app->authManager;

        return $user->save() && $auth->assign($auth->getRole('Client'), $user->getId());
    }
}
