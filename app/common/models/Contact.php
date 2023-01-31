<?php

declare(strict_types=1);

namespace common\models;

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
 * @property int $user_id Пользователь
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 * @property User $user
 */
class Contact extends ActiveRecord
{
    public $file;

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
                'skipOnEmpty' => false,
                'checkExtensionByMimeType' => true,
                'maxSize' => 3145728,
                'tooBig' => 'Limit is 3mb',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ИД',
            'title' => 'Тема',
            'message' => 'Сообщение',
            'line' => 'Ссылка',
            'user_id' => 'Пользователь',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
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
            $this->addError("file", "wrong format of file");

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
