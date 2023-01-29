<?php

declare(strict_types=1);

namespace common\models;

use Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id ИД
 * @property string $email Электронная почта
 * @property string $auth_key Ключ аунтификации
 * @property string $surname Фамилия
 * @property string $name Имя
 * @property string|null $patronymic Отчество
 * @property int $status Статус
 * @property string|null $verification_token Токен верификации
 * @property string $password_hash Хэш пароля
 * @property string|null $password_reset_token Токен сброса пароля
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 *
 * @property-read string $username
 * @property array $roles
 * @property-read string $authKey
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|IdentityInterface|null
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param $token
     * @param $type
     * @return array|User|ActiveRecord|IdentityInterface|null
     */
    public static function findIdentityByAccessToken(
        $token,
        $type = null
    ): User|array|ActiveRecord|IdentityInterface|null {
        return User::find()->where(['auth_key' => $token])->one();
    }

    /**
     * @param $email
     * @return User|array|ActiveRecord|null
     */
    public static function findIdentityByEmail($email): User|array|ActiveRecord|null
    {
        return User::find()->where(['email' => $email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                ['email', 'auth_key', 'surname', 'name', 'password_hash', 'created_at', 'updated_at'],
                'required'
            ],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [
                [
                    'email',
                    'surname',
                    'name',
                    'patronymic',
                    'verification_token',
                    'password_hash',
                    'password_reset_token'
                ],
                'string',
                'max' => 255
            ],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['roles'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ИД',
            'email' => 'Электронная почта',
            'auth_key' => 'Ключ аунтификации',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'status' => 'Статус',
            'verification_token' => 'Токен верификации',
            'password_hash' => 'Хэш пароля',
            'password_reset_token' => 'Токен сброса пароля',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'roles' => 'Должность',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return array_keys(Yii::$app->authManager->getRolesByUser($this->id));
    }

    /**
     * @param $roles
     * @return void
     * @throws Exception
     */
    public function setRoles($roles): void
    {
        // delete user role
        foreach (array_diff($this->roles, ($roles ?: [])) as $item) {
            Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($item), $this->id);
        }

        // add user role
        foreach (array_diff(($roles ?: []), $this->roles) as $item) {
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($item), $this->id);
        }
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $arr
     * @return array
     */
    public function structureRoles(array $arr): array
    {
        $tmp = [];

        foreach ($arr as $item) {
            $tmp[$item] = $item;
        }

        return $tmp;
    }

    /**
     * @return bool
     */
    public function beforeDelete(): bool
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        return Yii::$app->authManager->revokeAll($this->id);
    }
}
