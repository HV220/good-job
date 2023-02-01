<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public ?string $email = null;
    public string $password;
    public bool $rememberMe = true;
    private ?User $user = null;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * @return array|User|ActiveRecord|null
     */
    protected function getUser(): User|array|ActiveRecord|null
    {
        if ($this->user === null) {
            $this->user = User::findIdentityByEmail($this->email);
        }

        return $this->user;
    }

    /**
     * @param $attribute
     * @return void
     */
    public function validatePassword($attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
}
