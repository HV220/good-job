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
class RegistrationForm extends Model
{
    public ?string $name = null;
    public ?string $email = null;
    public string $password;
    private ?User $user = null;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'validateUser'],
            ['password', 'required'],
        ];
    }

    /**
     * @return bool
     */
    public function registration(): bool
    {
        if ($this->validate() && !$this->hasErrors()) {
            $this->user = new User();

            $this->user->name = $this->name;
            $this->user->surname = $this->name;
            $this->user->email = $this->email;
            $this->user->created_at = time();
            $this->user->updated_at = time();
            $this->user->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $this->user->auth_key = Yii::$app->security->generateRandomString(12);
            $this->user->save(false);

            $this->user->setRoles(['Клиент']);

            return true;
        }

        return false;
    }

    /**
     * @param $attribute
     * @return void
     */
    public function validateUser($attribute): void
    {
        if ($this->getUser()) {
            $this->addError($attribute, 'Такой пользователь уже существует');
        }
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

}
