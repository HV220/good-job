<?php

declare(strict_types=1);

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@backend', dirname(__DIR__, 2) . '/backend');
Yii::setAlias('@console', dirname(__DIR__, 2) . '/console');

Dotenv\Dotenv::createMutable(dirname(__DIR__, 2))->load();
