<?php

namespace frontend\models;



use Yii;
   use common\modules\profile\models\Profile;
   use app\models\ProfileAssessor;
    use frontend\models\SetkabAssessee;

/**
 * This is the model class for table "setkab_activity".
 *
 * @property string $id
 * @property integer $assessee_id
 * @property integer $assessor_id
 * @property integer $second_opinion_id
 * @property string $no_test
 * @property string $tanggal_test
 * @property string $tempat_test
 * @property string $tujuan_pemeriksaan
 * @property string $saran
 * @property string $executive_summary
 * @property string $kekuatan
 * @property string $kelemahan
 * @property integer $integritas_lki
 * @property string $integritas_uraian
 * @property integer $kerjasama_lki
 * @property string $kerjasama_uraian
 * @property integer $komunikasi_lki
 * @property string $komunikasi_uraian
 * @property integer $orientasihasil_lki
 * @property string $orientasihasil_uraian
 * @property integer $pelayananpublik_lki
 * @property string $pelayananpublik_uraian
 * @property integer $pengembangandiri_lki
 * @property string $pengembangandiri_uraian
 * @property integer $pengelolaanperubahan_lki
 * @property string $pengelolaanperubahan_uraian
 * @property integer $pengambilankeputusan_lki
 * @property string $pengambilankeputusan_uraian
 * @property integer $perekatbangsa_lki
 * @property string $perekatbangsa_uraian
 * @property string $integritas_indikator
 * @property string $kerjasama_indikator
 * @property string $komunikasi_indikator
 * @property string $orientasihasil_indikator
 * @property string $pelayananpublik_indikator
 * @property string $pengembangandiri_indikator
 * @property string $pengelolaanperubahan_indikator
 * @property string $pengambilankeputusan_indikator
 * @property string $perekatbangsa_indikator
 * @property integer $psikogram_berpikiranalitis
 * @property integer $psikogram_empati
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
 * @property integer $psikogram_fleksibilitasberpikir
 * @property string $status
 */
class SetkabActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setkab_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assessee_id', 'assessor_id', 'second_opinion_id', 'integritas_lki', 'kerjasama_lki', 'komunikasi_lki', 'orientasihasil_lki', 'pelayananpublik_lki', 'pengembangandiri_lki', 'pengelolaanperubahan_lki', 'pengambilankeputusan_lki', 'perekatbangsa_lki', 'psikogram_berpikiranalitis', 'psikogram_empati', 'psikogram_inteligensiumum', 'psikogram_kemampuanbelajar', 'psikogram_ketekunan', 'psikogram_ketelitian', 'psikogram_komunikasiefektif', 'psikogram_konsepdiri', 'psikogram_logikaberpikir', 'psikogram_motivasi', 'psikogram_pemahamansosial', 'psikogram_pengaturandiri', 'psikogram_sistematikakerja', 'psikogram_tempokerja', 'psikogram_fleksibilitasberpikir'], 'integer'],
            [['tanggal_test'], 'safe'],
                [['indikatorarrayintegritas'], 'safe'],
                [['indikatorarraykerjasama'], 'safe'],
                [['indikatorarraykomunikasi'], 'safe'],
                [['indikatorarrayorientasihasil'], 'safe'],
                [['indikatorarraypelayananpublik'], 'safe'],
                [['indikatorarraypengambilankeputusan'], 'safe'],
                [['indikatorarraypengelolaanperubahan'], 'safe'],
                [['indikatorarraypengembangandiri'], 'safe'],
                [['indikatorarrayperekatbangsa'], 'safe'],
            [['saran', 'executive_summary', 'kekuatan', 'kelemahan', 'integritas_uraian', 'kerjasama_uraian', 'komunikasi_uraian', 'orientasihasil_uraian', 'pelayananpublik_uraian', 'pengembangandiri_uraian', 'pengelolaanperubahan_uraian', 'pengambilankeputusan_uraian', 'perekatbangsa_uraian'], 'string'],
            [['no_test', 'tempat_test', 'tujuan_pemeriksaan', 'integritas_indikator', 'kerjasama_indikator', 'komunikasi_indikator', 'orientasihasil_indikator', 'pelayananpublik_indikator', 'pengembangandiri_indikator', 'pengelolaanperubahan_indikator', 'pengambilankeputusan_indikator', 'perekatbangsa_indikator', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'assessee_id' => Yii::t('app', 'Assessee ID'),
            'assessor_id' => Yii::t('app', 'Assessor ID'),
            'second_opinion_id' => Yii::t('app', 'Second Opinion ID'),
            'no_test' => Yii::t('app', 'No Test'),
            'tanggal_test' => Yii::t('app', 'Tanggal Test'),
            'tempat_test' => Yii::t('app', 'Tempat Test'),
            'tujuan_pemeriksaan' => Yii::t('app', 'Tujuan Pemeriksaan'),
            'saran' => Yii::t('app', 'Saran'),
            'executive_summary' => Yii::t('app', 'Executive Summary'),
            'kekuatan' => Yii::t('app', 'Kekuatan'),
            'kelemahan' => Yii::t('app', 'Kelemahan'),
            'integritas_lki' => Yii::t('app', 'Integritas Lki'),
            'integritas_uraian' => Yii::t('app', 'Integritas Uraian'),
            'kerjasama_lki' => Yii::t('app', 'Kerjasama Lki'),
            'kerjasama_uraian' => Yii::t('app', 'Kerjasama Uraian'),
            'komunikasi_lki' => Yii::t('app', 'Komunikasi Lki'),
            'komunikasi_uraian' => Yii::t('app', 'Komunikasi Uraian'),
            'orientasihasil_lki' => Yii::t('app', 'Orientasihasil Lki'),
            'orientasihasil_uraian' => Yii::t('app', 'Orientasihasil Uraian'),
            'pelayananpublik_lki' => Yii::t('app', 'Pelayananpublik Lki'),
            'pelayananpublik_uraian' => Yii::t('app', 'Pelayananpublik Uraian'),
            'pengembangandiri_lki' => Yii::t('app', 'Pengembangandiri Lki'),
            'pengembangandiri_uraian' => Yii::t('app', 'Pengembangandiri Uraian'),
            'pengelolaanperubahan_lki' => Yii::t('app', 'Pengelolaanperubahan Lki'),
            'pengelolaanperubahan_uraian' => Yii::t('app', 'Pengelolaanperubahan Uraian'),
            'pengambilankeputusan_lki' => Yii::t('app', 'Pengambilankeputusan Lki'),
            'pengambilankeputusan_uraian' => Yii::t('app', 'Pengambilankeputusan Uraian'),
            'perekatbangsa_lki' => Yii::t('app', 'Perekatbangsa Lki'),
            'perekatbangsa_uraian' => Yii::t('app', 'Perekatbangsa Uraian'),
            'integritas_indikator' => Yii::t('app', 'Integritas Indikator'),
            'kerjasama_indikator' => Yii::t('app', 'Kerjasama Indikator'),
            'komunikasi_indikator' => Yii::t('app', 'Komunikasi Indikator'),
            'orientasihasil_indikator' => Yii::t('app', 'Orientasihasil Indikator'),
            'pelayananpublik_indikator' => Yii::t('app', 'Pelayananpublik Indikator'),
            'pengembangandiri_indikator' => Yii::t('app', 'Pengembangandiri Indikator'),
            'pengelolaanperubahan_indikator' => Yii::t('app', 'Pengelolaanperubahan Indikator'),
            'pengambilankeputusan_indikator' => Yii::t('app', 'Pengambilankeputusan Indikator'),
            'perekatbangsa_indikator' => Yii::t('app', 'Perekatbangsa Indikator'),
            'psikogram_berpikiranalitis' => Yii::t('app', 'Psikogram Berpikiranalitis'),
            'psikogram_empati' => Yii::t('app', 'Psikogram Empati'),
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
            'psikogram_fleksibilitasberpikir' => Yii::t('app', 'Psikogram Fleksibilitasberpikir'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return SetkabActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetkabActivityQuery(get_called_class());
    }

	public function getAssessee()
 {
return $this->hasOne(SetkabAssessee::className(), ['id' => 'assessee_id']);
 }

  	public function getAssessor()
 {
return $this->hasOne(Profile::className(), ['user_id' => 'assessor_id']);
 }

 public function getassessorName()
 {
    return $this->hasOne(ProfileAssessor::className(), ['id' => 'no_test']);
 }

 public function getSecondopinion()
 {
return $this->hasOne(Profile::className(), ['user_id' => 'second_opinion_id']);
 }

    public function getIndikatorarrayintegritas()
    {
        return json_decode($this->integritas_indikator);
    }

    public function setIndikatorarrayintegritas($value)
    {
        $this->integritas_indikator = json_encode($value);
    }

    public function getIndikatorarraykerjasama()
    {
        return json_decode($this->kerjasama_indikator);
    }

    public function setIndikatorarraykerjasama($value)
    {
        $this->kerjasama_indikator = json_encode($value);
    }

    public function getIndikatorarraykomunikasi()
    {
        return json_decode($this->komunikasi_indikator);
    }

    public function setIndikatorarraykomunikasi($value)
    {
        $this->komunikasi_indikator = json_encode($value);
    }

    public function getIndikatorarrayorientasihasil()
    {
        return json_decode($this->orientasihasil_indikator);
    }

    public function setIndikatorarrayorientasihasil($value)
    {
        $this->orientasihasil_indikator = json_encode($value);
    }

    public function getIndikatorarraypelayananpublik()
    {
        return json_decode($this->pelayananpublik_indikator);
    }

    public function setIndikatorarraypelayananpublik($value)
    {
        $this->pelayananpublik_indikator = json_encode($value);
    }

    public function getIndikatorarraypengambilankeputusan()
    {
        return json_decode($this->pengambilankeputusan_indikator);
    }

    public function setIndikatorarraypengambilankeputusan($value)
    {
        $this->pengambilankeputusan_indikator = json_encode($value);
    }

    public function getIndikatorarraypengelolaanperubahan()
    {
        return json_decode($this->pengelolaanperubahan_indikator);
    }

    public function setIndikatorarraypengelolaanperubahan($value)
    {
        $this->pengelolaanperubahan_indikator = json_encode($value);
    }

    public function getIndikatorarraypengembangandiri()
    {
        return json_decode($this->pengembangandiri_indikator);
    }

    public function setIndikatorarraypengembangandiri($value)
    {
        $this->pengembangandiri_indikator = json_encode($value);
    }

    public function getIndikatorarrayperekatbangsa()
    {
        return json_decode($this->perekatbangsa_indikator);
    }

    public function setIndikatorarrayperekatbangsa($value)
    {
        $this->perekatbangsa_indikator = json_encode($value);
    }
}
