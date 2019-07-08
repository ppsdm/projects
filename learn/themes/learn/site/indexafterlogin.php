<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use pao\modules\catalog\models\CatalogGeneral;
use pao\modules\profile\models\ProfileExtended;
use pao\modules\tao\models\TaoUriMap;
use pao\modules\catalog\models\CatalogPrice;
use pao\modules\assessment\models\AssessmentResult;

use kartik\social\FacebookPlugin;
use kartik\sidenav\SideNav;


$this->title = 'Siap Ngampus | Belajar & Ujian Online';

/* @var $this yii\web\View */
?>
<div class="row">
  <div class="col-md-9 col-md-push-3">
<?php
echo $this->render('//../modules/assessment/views/assessment/index', ['dataProvider' => $dataProvider,'searchModel' => $searchModel]);



$ed_level = ProfileExtended::find()->andWhere(['type' => 'edulab'])->andWhere(['user_id' => Yii::$app->user->id])->andWhere(['key' =>'ed_level'])->One();
//echo $ed_level->value;

//$this->render($ed_level->value .'_statistics', ['model' => $model,]);




/*


echo '<div class="col-lg-6">
                <h2>Statistik</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

            </div>';

*/
?>
</div>
<div class="col-md-3 col-md-pull-9">
  <?php
    echo SideNav::widget([

        'encodeLabels' => false,

        'items' => [
            // Important: you need to specify url as 'controller/action',
            // not just as 'controller' even if default action is used.
            //
            // NOTE: The variable `$item` is specific to this demo page that determines
            // which menu item will be activated. You need to accordingly define and pass
            // such variables to your view object to handle such logic in your application
            // (to determine the active status).
            //
            ['label' => 'MATA PELAJARAN', 'icon' => 'pencil', 'url' => Url::to(['/site/home']), 'active' => ('label' == 'home')],

            ['label' => 'Bahasa Indonesia', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Bahasa Indonesia')],
            ['label' => 'Bahasa Inggris', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Bahasa Inggris')],
            ['label' => 'Matematika', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Matematika')],
            ['label' => 'Fisika', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Fisika')],
            ['label' => 'Geografi', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Geografi')],
            ['label' => 'Sosiologi', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Sosiolosi')],
            ['label' => 'Biologi', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Biologi')],
            ['label' => 'Kimia', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Kimia')],
        ],
    ]);

    echo SideNav::widget([

        'encodeLabels' => false,

        'items' => [
            // Important: you need to specify url as 'controller/action',
            // not just as 'controller' even if default action is used.
            //
            // NOTE: The variable `$item` is specific to this demo page that determines
            // which menu item will be activated. You need to accordingly define and pass
            // such variables to your view object to handle such logic in your application
            // (to determine the active status).
            //
            ['label' => 'LEADERBOARD', 'icon' => 'pencil', 'url' => Url::to(['/site/home']), 'active' => ('label' == 'home')],

            ['label' => 'Bahasa Indonesia', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Bahasa Indonesia')],
            ['label' => 'Bahasa Inggris', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Bahasa Inggris')],
            ['label' => 'Matematika', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Matematika')],
            ['label' => 'Fisika', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Fisika')],
            ['label' => 'Geografi', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Geografi')],
            ['label' => 'Sosiologi', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Sosiolosi')],
            ['label' => 'Biologi', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Biologi')],
            ['label' => 'Kimia', 'icon' => 'menu-right', 'url' => Url::to(['']), 'active' => ('label' == 'Kimia')],
        ],
    ]);
  ?>
</div>
</div>

        </div>

    </div>
</div>
