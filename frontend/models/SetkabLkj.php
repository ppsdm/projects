<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "setkab_lkj".
 *
 * @property string $id
 * @property string $golongan
 * @property string $jabatan
 * @property string $level
 * @property integer $psikogram_berpikiranalitis
 * @property integer $psikogram_empati
 * @property integer $psikogram_eq
 * @property integer $psikogram_inteligensiumum
 * @property integer $psikogram_kemampuanbelajar
 * @property integer $psikogram_ketekunan
 * @property integer $psikogram_ketelitian
 * @property integer $psikogram_komunikasiefektif
 * @property integer $psikogram_konsepdiri
 * @property integer $psikogram_logikaberpikir
 * @property integer $psikogram_motivasi
 * @property integer $psikogram_pemahamansosial
 * @property integer $psikogram_pengaturandiri
 * @property integer $psikogram_sistematikakerja
 * @property integer $psikogram_tempokerja
 * @property integer $kompetensigram_integritas
 * @property integer $kompetensigram_kerjasama
 * @property integer $kompetensigram_komunikasi
 * @property integer $kompetensigram_orientasihasil
 * @property integer $kompetensigram_pelayananpublik
 * @property integer $kompetensigram_pengembangandiri
 * @property integer $kompetensigram_pengelolaanperubahan
 * @property integer $kompetensigram_pengambilankeputusan
 * @property integer $kompetensigram_perekatbangsa
 */
class SetkabLkj extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setkab_lkj';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['psikogram_berpikiranalitis', 'psikogram_empati', 'psikogram_eq', 'psikogram_inteligensiumum', 'psikogram_kemampuanbelajar', 'psikogram_ketekunan', 'psikogram_ketelitian', 'psikogram_komunikasiefektif', 'psikogram_konsepdiri', 'psikogram_logikaberpikir', 'psikogram_motivasi', 'psikogram_pemahamansosial', 'psikogram_pengaturandiri', 'psikogram_sistematikakerja', 'psikogram_tempokerja', 'kompetensigram_integritas', 'kompetensigram_kerjasama', 'kompetensigram_komunikasi', 'kompetensigram_orientasihasil', 'kompetensigram_pelayananpublik', 'kompetensigram_pengembangandiri', 'kompetensigram_pengelolaanperubahan', 'kompetensigram_pengambilankeputusan', 'kompetensigram_perekatbangsa'], 'integer'],
            [['golongan', 'jabatan', 'level'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'golongan' => Yii::t('app', 'Golongan'),
            'jabatan' => Yii::t('app', 'Jabatan'),
            'level' => Yii::t('app', 'Level'),
            'psikogram_berpikiranalitis' => Yii::t('app', 'Psikogram Berpikiranalitis'),
            'psikogram_empati' => Yii::t('app', 'Psikogram Empati'),
            'psikogram_eq' => Yii::t('app', 'Psikogram Eq'),
            'psikogram_inteligensiumum' => Yii::t('app', 'Psikogram Inteligensiumum'),
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
     * @inheritdoc
     * @return SetkabLkjQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetkabLkjQuery(get_called_class());
    }
}
