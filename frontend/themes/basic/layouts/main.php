<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use common\widgets\Alert;

use app\modules\profile\models\Profile;
use app\modules\profile\models\ProfileMeta;
use app\modules\profile\models\ProfileSearch;

use machour\yii2\notifications\widgets\NotificationsWidget;
use common\modules\core\models\Notification;



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


NotificationsWidget::widget([
    'theme' => NotificationsWidget::THEME_GROWL,
    'clientOptions' => [
        'location' => 'id',
    ],
    'counters' => [
        '.notifications-header-count',
        '.notifications-icon-count'
    ],
    'markAllSeenSelector' => '#notification-seen-all',
    'listSelector' => '#notifications',
]);

?>

<?php
    NavBar::begin([
        'brandLabel' => 'PPSDM.COM',
        'brandLabel' => Html::img('/images/ppsdm-logo-atas.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
      //  ['label' => 'About', 'url' => ['/site/about']],
      //  ['label' => 'Contact', 'url' => ['/site/contact']],
       //'linkOptions' => ['style' => 'background-color: #F86D18;color: #ffffff;']]

    ];


    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $isso = true;
        if ($isso) {
            $menuItems[] = ['label' => 'Panduan', 'url' => ['/setkab-activity/help']];
            $menuItems[] = ['label' => 'Second Opinion', 'url' => ['/setkab-activity/soindex']];
        }

        if (isset(Yii::$app->user->identity->profile->id)) {
$profile_id = Yii::$app->user->identity->profile->id;
        } else {
            $profile_id = '';
        }
        $projectmodule = ProfileMeta::find()->andWhere(['profile_id' => $profile_id])->andWhere(['type' => 'config'])
        ->andWhere(['key' => 'module'])
        ->andWhere(['value' => 'project'])
        ->andWhere(['attribute_1' => 'active'])
        ->One();
        if(null !== $projectmodule){
           // $menuItems[] = ['label' => 'Projects', 'url' => ['/projects/project/select']];
        }

        //$menuItems[] = ['label' => 'Profile', 'url' => ['/profile/profile']];
        //$menuItems[] = ['label' => 'Assessor/Assessee/User Dashboard', 'url' => ['/project/project/select']];
        //$menuItems[] = ['label' => 'Debug', 'url' => ['/site/debug']];
        //$menuItems[] = ['label' => 'File / ScanReader', 'url' => ['/file/upload']];


  $menuItems[] = '
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning notifications-icon-count">0</span>
    </a>
    <ul class="dropdown-menu" style="width:215px;">
        <li class="dropdown-header">
        <a href=""></a><B>'.
Html::a(Yii::t('app', 'You have <span class="notifications-header-count">0</span> notifications'), ['/message/index'], ['class'=>''])
.'</B>
        </li>
        <li>
            <div id="notifications"></div>
        </li>
    </ul>
</li>';

          $menuItems[] = '    <li class="dropdown" style="list-style: none;">'

.Html::a(Yii::t('app', '<span class="glyphicon glyphicon-user"></span> ' . Yii::$app->user->identity->username ), [''], ['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']) .
       '<ul class="dropdown-menu">
           <li>'.Html::a(Yii::t('app', 'Profile'), ['/profile/profile/update','id'=>$profile_id], ['class'=>'']) .'</li>
              <li class="divider"></li><li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
.
           '
         </ul>
   </li>';


        //$menuItems[] = ;
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; PPSDM <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
