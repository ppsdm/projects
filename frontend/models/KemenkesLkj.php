<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kemenkes_lkj".
 *
 * @property int $id
 * @property string $golongan
 * @property string $jabatan
 * @property string $level
 * @property int $psikogram_kemampuananalisa
 * @property int $psikogram_empati
 * @property int $psikogram_kemampuanumum
 * @property int $psikogram_kemampuanbelajar
 * @property int $psikogram_ketekunan
 * @property int $psikogram_ketelitian
 * @property int $psikogram_komunikasiefektif
 * @property int $psikogram_konsepdiri
 * @property int $psikogram_logikaberpikir
 * @property int $psikogram_motivasi
 * @property int $psikogram_pemahamansosial
 * @property int $psikogram_pengaturandiri
 * @property int $psikogram_sistematikakerja
 * @property int $psikogram_tempokerja
 * @property int $psikogram_inisiatif
 * @property int $kompetensigram_integritas
 * @property int $kompetensigram_kerjasama
 * @property int $kompetensigram_komunikasi
 * @property int $kompetensigram_orientasihasil
 * @property int $kompetensigram_pelayananpublik
 * @property int $kompetensigram_pengembangandiri
 * @property int $kompetensigram_pengelolaanperubahan
 * @property int $kompetensigram_pengambilankeputusan
 * @property int $kompetensigram_perekatbangsa
 */
class KemenkesLkj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kemenkes_lkj';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('projectsdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['psikogram_kemampuananalisa', 'psikogram_empati', 'psikogram_kemampuanumum', 'psikogram_kemampuanbelajar', 'psikogram_ketekunan', 'psikogram_ketelitian', 'psikogram_komunikasiefektif', 'psikogram_konsepdiri', 'psikogram_logikaberpikir', 'psikogram_motivasi', 'psikogram_pemahamansosial', 'psikogram_pengaturandiri', 'psikogram_sistematikakerja', 'psikogram_tempokerja', 'psikogram_inisiatif', 'kompetensigram_integritas', 'kompetensigram_kerjasama', 'kompetensigram_komunikasi', 'kompetensigram_orientasihasil', 'kompetensigram_pelayananpublik', 'kompetensigram_pengembangandiri', 'kompetensigram_pengelolaanperubahan', 'kompetensigram_pengambilankeputusan', 'kompetensigram_perekatbangsa'], 'integer'],
            [['golongan', 'jabatan', 'level'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'golongan' => Yii::t('app', 'Golongan'),
            'jabatan' => Yii::t('app', 'Jabatan'),
            'level' => Yii::t('app', 'Level'),
            'psikogram_kemampuananalisa' => Yii::t('app', 'Psikogram Kemampuananalisa'),
            'psikogram_empati' => Yii::t('app', 'Psikogram Empati'),
            'psikogram_kemampuanumum' => Yii::t('app', 'Psikogram Kemampuanumum'),
            'psikogram_kemampuanbelajar' => Yii::t('app', 'Psikogram Kemampuanbelajar'),
            'psikogram_ketekunan' => Yii::t('app', 'Psikogram Ketekunan'),
            'psikogram_ketelitian' => Yii::t('app', 'Psikogram Ketelitian'),
            'psikogram_komunikasiefektif' => Yii::t('app', 'Psikogram Komunikasiefektif'),
            'psikogram_konsepdiri' => Yii::t('app', 'Psikogram Konsepdiri'),
            'psikogram_logikaberpikir' => Yii::t('app', 'Psikogram Logikaberpikir'),
            'psikogram_motivasi' => Yii::t('app', 'Psikogram Motivasi'),
            'psikogram_pemahamansosial' => Yii::t('app', 'Psikogram Pemahamansosial'),
            'psikogram_pengaturandiri' => Yii::t('app', 'Psikogram Pengaturandiri'),
            'psikogram_sistematikakerja' => Yii::t('app', 'Psikogram Sistematikakerja'),
            'psikogram_tempokerja' => Yii::t('app', 'Psikogram Tempokerja'),
            'psikogram_inisiatif' => Yii::t('app', 'Psikogram Inisiatif'),
            'kompetensigram_integritas' => Yii::t('app', 'Kompetensigram Integritas'),
            'kompetensigram_kerjasama' => Yii::t('app', 'Kompetensigram Kerjasama'),
            'kompetensigram_komunikasi' => Yii::t('app', 'Kompetensigram Komunikasi'),
            'kompetensigram_orientasihasil' => Yii::t('app', 'Kompetensigram Orientasihasil'),
            'kompetensigram_pelayananpublik' => Yii::t('app', 'Kompetensigram Pelayananpublik'),
            'kompetensigram_pengembangandiri' => Yii::t('app', 'Kompetensigram Pengembangandiri'),
            'kompetensigram_pengelolaanperubahan' => Yii::t('app', 'Kompetensigram Pengelolaanperubahan'),
            'kompetensigram_pengambilankeputusan' => Yii::t('app', 'Kompetensigram Pengambilankeputusan'),
            'kompetensigram_perekatbangsa' => Yii::t('app', 'Kompetensigram Perekatbangsa'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return KemenkesLkjQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KemenkesLkjQuery(get_called_class());
    }
}
