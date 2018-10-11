<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SetkabActivity */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setkab Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/*
global $min;
global $max;

$min = 200;
$max = 335;

$saran_min = 200;
$saran_max = 335;
$exsum_min = 300;
$exsum_max = 500;
*/

function countWord($uraian)
{

    $dom = new DOMDocument;
$li_count = 0;
$word_count = 0;

if (!empty($uraian)) {
$dom->loadHTML($uraian);

$new_element = $dom->createElement('test', ' ');
foreach($dom->getElementsByTagName('li') as $li) {
    $li_count = $li_count + str_word_count(strip_tags($li->textContent));
}

    foreach($dom->getElementsByTagName('ul') as $ul) {
        $ul->parentNode->replaceChild($new_element,$ul);
        $dom->saveHTML();

    }
    foreach($dom->getElementsByTagName('ol') as $ol) {
        $ol->parentNode->replaceChild($new_element,$ol);
        $dom->saveHTML();

    }


   $replaced_dom = preg_replace('#\<(.+?)\>#', ' ', $dom->saveHTML());
    $word_count = str_word_count(strip_tags($replaced_dom));
}
    $total_count = $word_count + $li_count;
    
   return $total_count; 

}
?>
<div class="setkab-activity-view">

<div class="activity-view">

    <h1><span>
        <?php
        
        echo Html::img('@web/project-uploads/setkab/photos/'.$model->assessee->id.'.JPG', ['alt' => '--missing image--','style'=> 'max-width:200px;max-height:200px'
            ]);
        ?>
    </span><?= Html::encode($model->assessee->nama_lengkap) ?></h1>

    <p>

		       
<?php
 //echo Html::a(Yii::t('app', 'Print PDF'), ['pdf', 'id' => $model->id], ['class' => 'btn btn-primary']);

if (($model->status == 'submitted')) {
if ($role == 'secondopinion') {
    echo Html::a(Yii::t('app', 'Selesai di review oleh SO'), ['reviewed', 'id' => $model->id], [
        'class' => 'btn btn-success',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure?'),
            'method' => 'post',
        ],
    ]);
    echo Html::a(Yii::t('app', 'Dikembalikan ke assessor'), ['returned', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure?'),
            'method' => 'post',
        ],
    ]);
}
        } elseif (($model->status == 'reviewed')) {


        } else {
            echo Html::a(Yii::t('app', 'Submit Assessment'), ['submit', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to submit this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>
    <h3>Status laporan : <?= $model->status?></h3>
<h3>Uraian</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label' => 'Data Diri',
                'format' => 'raw',
                'value' => function($data)
                {
                    return Html::a(Yii::t('app', 'Edit'), ['datadiri', 'id' => $data->id], ['class' => 'btn btn-primary']);
                }

            ],
            [
                'label' => 'Executive Summary',
                'format' => 'raw',
                'value' => function($data) use ($exsum_max, $exsum_min)
                {
                    //$words = $this->context->countWord($data->executive_summary); 
                    //$words = Yii::$app->runAction('actionCountword', ['uraian' => $data->executive_summary]);
					$words = str_word_count(strip_tags($data->executive_summary));
					$characters = strlen(str_replace(' ','',strip_tags($data->executive_summary)));
                    
                    if (($words <= $exsum_max) && ($words >= $exsum_min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['exsum', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$exsum_min.', max = '.$exsum_max.')';
               
                }

            ],

            [
                'label' => 'Kekuatan',
                'format' => 'raw',
                'value' => function($data) use ($saran_max, $saran_min)
                {
                    $words = str_word_count(strip_tags($data->kekuatan));
					$characters = strlen(str_replace(' ','',strip_tags($data->kekuatan)));
                    
                    if (($words <= $saran_max) && ($words >= $saran_min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['kekuatan', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$saran_min.', max = '.$saran_max.')';
               
                }

            ],
            [
                'label' => 'Kelemahan',
                'format' => 'raw',
                'value' => function($data) use ($saran_max, $saran_min)
                {
                    $words = str_word_count(strip_tags($data->kelemahan));
					$characters = strlen(str_replace(' ','',strip_tags($data->kelemahan)));
                    
                    if (($words <= $saran_max) && ($words >= $saran_min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['kelemahan', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$saran_min.', max = '.$saran_max.')';

                }

            ],
            [
                'label' => 'Saran Pengembangan',
                'format' => 'raw',
                'value' => function($data) use ($saran_max, $saran_min)
                {
                    $words = str_word_count(strip_tags($data->saran));
					$characters = strlen(str_replace(' ','',strip_tags($data->saran)));
                    
                    if (($words <= $saran_max) && ($words >= $saran_min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['saran', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$saran_min.', max = '.$saran_max.')';

                }

            ],


//            'tanggal_test',
  //          'tempat_test',
    //        'tujuan_pemeriksaan',
        ],
    ]) ?>
<h3>Aspek Potensi</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Psikogram',
                'format' => 'raw',
                'value' => function($data)
                {
                    return Html::a(Yii::t('app', 'Edit'), ['psikogram', 'id' => $data->id], ['class' => 'btn btn-primary']);
                }

            ],

        ],
    ]) ?>

<h3>Aspek Kompetensi</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label' => 'Integritas',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
                    //check kalau textnya jumlah nya cukup
					
					$words = str_word_count(strip_tags($data->integritas_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->integritas_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['integritas', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }

            ],
            [
                'label' => 'Kerjasama',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->kerjasama_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->kerjasama_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['kerjasama', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }
            ],
            [
                'label' => 'Komunikasi',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->komunikasi_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->komunikasi_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['komunikasi', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }
            ],
            [
                'label' => 'Orientasi pada hasil',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->orientasihasil_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->orientasihasil_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['orientasihasil', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }
            ],
            [
                'label' => 'Pelayanan Publik',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->pelayananpublik_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->pelayananpublik_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['pelayananpublik', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }
            ],
            [
                'label' => 'Pengembangan Diri dan Orang Lain',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->pengembangandiri_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->pengembangandiri_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['pengembangandiri', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }
            ],
            [
                'label' => 'Mengelola Perubahan',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->pengelolaanperubahan_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->pengelolaanperubahan_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['perubahan', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';
                }
            ],
            [
                'label' => 'Pengambilan Keputusan',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->pengambilankeputusan_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->pengambilankeputusan_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['pengambilankeputusan', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';

                }
            ],
            [
                'label' => 'Perekat Bangsa',
                'format' => 'raw',
                'value' => function($data) use ($min, $max)
                {
					$words = str_word_count(strip_tags($data->perekatbangsa_uraian));
					$characters = strlen(str_replace(' ','',strip_tags($data->perekatbangsa_uraian)));
                    
                    if (($words <= $max) && ($words >= $min))
                    {
                        $btn_class = 'btn btn-success';
                    } else {
                        $btn_class = 'btn btn-warning';
                    }

					
                    return Html::a(Yii::t('app', 'Edit'), ['perekatbangsa', 'id' => $data->id], ['class' => $btn_class]) . ' #words = ' . $words . ' (min = '.$min.', max = '.$max.')';

                }
            ],
            //'tanggal_test',
            //'tempat_test',
            //'tujuan_pemeriksaan',
        ],
    ]) ?>

</div>
