<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;

?>

<div class="site-index">

    <?if(!Yii::$app->user->isGuest):?>
        <div class="big-timer" data-time="<?=Yii::$app->user->identity->lastlogin_at?>"></div>
    <?endif?>

</div>
