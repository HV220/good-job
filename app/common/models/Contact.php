<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "contact".
 *
 * @property int $id ИД
 * @property string $title Тема
 * @property string $message Сообщение
 * @property string $line Cсылка на файл
 * @property int $user_id ID Клиента
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 * @property User $user Пользователь
 */
class Contact extends ActiveRecord
{
    public mixed $file = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'contact';
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
//            $this->sendMessageEmail();
        }
    }

    /**
     * @return bool
     */
    public function sendMessageEmail(): bool
    {
        $usersManager = Yii::$app->authManager->getUserIdsByRole('Manager');

        if (!$usersManager) {
            return false;
        }

        $managers = User::findAll(['id' => $usersManager]);

        $item = [];

        foreach ($managers as $manager) {
            $item[] = $manager->email;
        }
        Yii::$app->mailer->compose()
            ->setFrom($_ENV['SMTP_USER'])
            ->setTo('$item')
            ->setSubject($this->title)
            ->setTextBody($this->message)
            ->send();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'message'], 'required'],
            [['message'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
            [
                ['file'],
                'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => true,
                'maxSize' => 3145728,
                'tooBig' => 'Максимальный размер: 3 мегабайта',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ИД',
            'title' => 'Тема',
            'message' => 'Текст сообщения',
            'line' => 'Ссылка на прикрепленный файл',
            'user_id' => 'ID Клиента',
            'created_at' => 'Время отправки сообщения',
            'updated_at' => 'Обновлено',
            'file' => 'Файл',
        ]);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return bool
     */
    public function upload(): bool
    {
        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->file->extension === 'exe' || $this->file->extension === 'jar' || $this->file->extension === 'bat') {
            $this->addError("file", "Данный формат не поддерживается");

            return false;
        }

        if ($this->validate()) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);

            $this->line = '/uploads/' . $this->file->baseName . '.' . $this->file->extension;

            return true;
        }

        return false;
    }
}