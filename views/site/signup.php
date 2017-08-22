<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Регистрация";
$this->params["breadcrumbs"][] = $this->title;
?>

<div class="site-login">


    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">

        <div class="col-lg-offset-4 col-lg-4">

            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n<div>{error}</div>",
                    'labelOptions' => ['class' => 'control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'username')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'passwordConfirm')->passwordInput() ?>

            <div class="form-group">
                <div class="text-right">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>
