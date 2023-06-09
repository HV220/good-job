<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id ИД
 * @property string $email Электронная почта
 * @property string $auth_key Ключ аунтификации
 * @property string $username Имя
 * @property int $status Статус
 * @property string|null $verification_token Токен верификации
 * @property string $password_hash Хэш пароля
 * @property string|null $password_reset_token Токен сброса пароля
 * @property int $created_at Время создания Клиента
 * @property int $updated_at Обновлено
 *
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
     * @return string[]
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        if ($insert) {
            $auth = Yii::$app->authManager;

            $auth->assign($auth->getRole('Client'), $this->id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                ['email', 'auth_key', 'username', 'password_hash'],
                'required'
            ],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [
                [
                    'email',
                    'username',
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ИД',
            'email' => 'Электронная почта',
            'auth_key' => 'Ключ аунтификации',
            'username' => 'Имя',
            'status' => 'Статус',
            'verification_token' => 'Токен верификации',
            'password_hash' => 'Хэш пароля',
            'password_reset_token' => 'Токен сброса пароля',
            'created_at' => 'Время создания Клиента',
            'updated_at' => 'Обновлено',
        ]);
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
     * @return bool
     */
    public function beforeDelete(): bool
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        return Yii::$app->authManager->revokeAll($this->id);
    }

    /**
     * @param $password
     * @return void
     * @throws Exception
     */
    public function setPassword($password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
