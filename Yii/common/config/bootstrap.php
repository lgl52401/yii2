<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@libs', dirname(dirname(__DIR__)) . '/../libs');
Yii::setAlias('@static', dirname(dirname(dirname(__DIR__))) . '/static');
Yii::setAlias('@uploadFile', dirname(dirname(dirname(__DIR__))) . '/uploadFile');