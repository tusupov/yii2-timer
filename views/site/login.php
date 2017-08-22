<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Войти';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?if(Yii::$app->getSession()->getFlash("registered")):?>
        <div class="alert alert-success" role="alert">
            Вы успешно зарегистрировались.
        </div>
    <?endif?>

    <div class="row">

        <div class="col-lg-offset-4 col-lg-4">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n<div>{error}</div>",
                    'labelOptions' => ['class' => 'control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'value' => Yii::$app->getSession()->get('login')]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "{input}\n{label}\n<div>{error}</div>",
            ]) ?>

            <div class="form-group">
                <div class="text-right">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>
