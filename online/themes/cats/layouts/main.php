<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\CatsAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\icons\Icon;
use common\modules\profile\models\UserCredit;
use common\modules\profile\models\ProfileExtended;

AppAsset::register($this);
CatsAsset::register($this);

$this->title = 'CATS PPSDM | Jobs that fit';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="yellow-tittle">
<div class="container">
<h3>  <?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?></h3>
</div>
</div>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo_kecil_cats.png', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default2 navbar-fixed-top',
        ],
    ]);
    ?>
    <div class="form-group">

    <?php
    $menuItems = [

    ];


    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = Html::a('Signup', ['/cats/cats/signup'], ['class'=>'btn-menu-transparent btn-trns']);

        $menuItems[] = Html::button('Login',['value'=>Url::toRoute('/cats/cats/loginpop'),'class'=>'btn-menu btn-success', 'id' =>'modalButton']);

        ?>
    </div>
        <?php
    } else {

        $usercredit = UserCredit::find()
        ->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['credit_type' => 'credit'])
                ->andWhere(['status' => 'active'])
        ->One();

//print_r($usercredit);
        if(!$usercredit) {
            $creditpoint = 0;
        } else {
            $creditpoint = $usercredit->credit_point;
        }
$selectionobj = ProfileExtended::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['type'=>'edulab'])->andWhere(['key'=>'ed_level'])->One();
if (is_null($selectionobj))
    $selection = '';
else
    $selection = $selectionobj->value;
//$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'Catalog'), ['/cats/assessment/index'], ['class'=>'']) . '</li>';
$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'Lowongan Pekerjaan'), ['/cats/jobs/index'], ['class'=>'']) . '</li>';
$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'Lamaran Anda'), ['/cats/applications/index'], ['class'=>'']) . '</li>';
$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'FAQ'), ['/cats/cats/faq'], ['class'=>'']) . '</li>';
$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'Informasi'), ['/cats/cats/info'], ['class'=>'']) . '</li>';
//$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'Lowongan Pekerjaan'), 'http://cats.ppsdm.com', ['class'=>'']) . '</li>';
                        //$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a(Yii::t('app', 'Profile'), ['/profile'], ['class'=>'btn btn-trns']) . '</li>';
                        $menuItems[] = '    <li class="dropdown" style="list-style: none;">'

.Html::a(Yii::t('app', '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> (' . Yii::$app->user->identity->username . ')<b class="caret"></b>'), ['/profile'], ['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']) .
        '<ul class="dropdown-menu">
            <li>
'.Html::a(Yii::t('app', 'Profile'), ['/cats/cats/profile'], ['class'=>'']) .'
            </li>
                        <li>
'.Html::a(Yii::t('app', 'Contact'), ['/site/contact'], ['class'=>'']) .'
            </li>
            <li>
'.Html::a(Yii::t('app', '*Report Bug'), ['/site/bugreport'], ['class'=>'']) .'
            </li>
            <li class="divider"></li>

                        <li>
'.Html::a(Yii::t('app', 'HR Admin'), ['/admin'], ['class'=>'']) . '
            </li>

                   <li class="divider"></li>
            <li>' .

                        Html::beginForm(['/site/logout'], 'post', ['id' => 'logoutbutton'])
           //. Html::Button(Yii::t('app', 'Logout'), [''], ['class'=>'','onclick' => 'document.getElementById("logoutbutton").submit()'])

            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                //['class' => 'btn btn-link']
                      ['class' => 'dropdown',
                      'style' => 'border:none;
 outline:none;
 background:none;
 cursor:pointer;
 color:#0000EE ;
 padding-left:20px;
 text-decoration:underline;
 font-family:inherit;
 font-size:inherit;'
                      ]
            )
            . Html::endForm()


//
 //$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a('Logout (' . Yii::$app->user->identity->username . ')', ['#'], ['class'=>'btn btn-trns', 'onclick' => 'document.getElementById("logoutbutton").submit()']) . '</li>';
            //Html::beginForm(['/site/logout'], 'post', ['id' => 'logoutbutton'])
            .'


            </li>
          </ul>
    </li>';





 //$menuItems[] = '<li class="dropdown" style="list-style:none;">' . Html::a('Logout (' . Yii::$app->user->identity->username . ')', ['#'], ['class'=>'btn btn-trns', 'onclick' => 'document.getElementById("logoutbutton").submit()']) . '</li>';

    }


      echo Html::beginForm(['/site/logout'], 'post', ['id' => 'logoutbutton']);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    echo Html::endForm();
    ?>
    <?php
        Modal::begin([
            'header' => '<h4>LOGIN</h4>',
            'id' => 'modal',
            'size' => 'modal-sm',
        ]);
        echo "<div id='modalContent'>
        </div>";
        Modal::End();
    ?>
    <div class="

<?php

if ((Yii::$app->controller->id == 'site') && (Yii::$app->controller->action->id == 'index')){
  echo '';
} else {
  echo'container';
}
?>
    ">


        <?= Alert::widget() ?>
        <?= $content ?>
        <?php
//echo Yii::$app->controller->id;
        ?>
</div>
</div>

<div id="footer">
<div class="container">

                  <div class="row" id="final-footer">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4">
                        <?=Html::img('@web/images/logo_kecil_cats.png', ['class'=>'img-responsive', 'align'=>'center']);?></BR>
                        <?= Html::a('Contact', ['/site/contact']); ?>
                        <?= (Yii::$app->user->isGuest) ? Html::a('Signup', ['/site/signup']) : ''; ?>
                    </div>
                    <div class="col-sm-4 text-right">

                    </div>
                  </div>
</div><!--/container-->
</div><!--/footer-->


            <div id="push"></div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
