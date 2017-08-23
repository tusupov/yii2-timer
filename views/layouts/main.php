<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'О нас', 'url' => ['/site/about']]
    ];

    if (Yii::$app->user->isGuest) {

        array_push(
            $menuItems,
            ['label' => 'Войти', 'url' => ['/site/login']],
            ['label' => 'Регистрация', 'url' => ['/site/signup']]
        );

    } else {

        $menuItems[] =
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        ;

    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems
    ]);

    NavBar::end();

    ?>

    <div class="container">

        <?= $content ?>

    </div>

</div>

<footer class="footer">

    <div class="container">

        <div class="row">
            <div class="col-md-4">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></div>
            <div class="col-md-4 text-center ut"></div>
            <div class="col-md-4 text-right"><?= Yii::powered() ?></div>
        </div>

    </div>

</footer>

<?if(!Yii::$app->user->isGuest){

    $username = Html::encode(Yii::$app->user->identity->username);
    $time     = (int) Yii::$app->user->identity->time;

    $this->registerJs("
        var ut = new UT()
        ut.startFunc('ut_{$username}', $time)
    ");

}?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
