<?php

namespace console\controllers;

use common\models\User;
use Faker\Factory;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreateFake($items = 500)
    {
        $faker = Factory::create();

        for ($i = 0; $i <= $items; $i++) {
            $user = new User();

            $user->email = $faker->email;
            $user->auth_key = Yii::$app->getSecurity()->generateRandomString();
            $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash('password_' . $i);
            $user->username = $faker->name;
            $user->status = User::STATUS_ACTIVE;

            $user->save();
        }
    }
}