<?php

namespace console\controllers;

use common\models\Contact;
use common\models\User;
use Faker\Factory;
use Yii;
use yii\console\Controller;

class ContactController extends Controller
{
    public function actionCreateFake($items = 500)
    {
        $faker = Factory::create();

        $usersClient = Yii::$app->authManager->getUserIdsByRole('Client');

        $users = User::find()->where(['id' => $usersClient])->limit($items)->all();

        foreach ($users as $user) {
            $contact = new Contact();

            $contact->user_id = $user->id;
            $contact->title = $faker->title();
            $contact->message = $faker->text(200);
            $contact->line = $faker->url;

            $contact->save();
        }
    }
}