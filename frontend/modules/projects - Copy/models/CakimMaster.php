<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "cakim_master".
 *
 * @property integer $id
 * @property string $reg_no
 * @property string $psikotes_no
 * @property string $lokasi
 * @property string $nama
 * @property string $usia
 * @property string $jenis_kelamin
 * @property string $tingkat_pendidikan
 * @property string $prospek_jabatan
 * @property string $tanggal_pemeriksaan
 * @property string $kemampuan_umum
 * @property string $kemampuan_berfikir_analisa_sintesa
 * @property string $kemampuan_berfikir_konseptual
 * @property string $kemampuan_proses_belajar
 * @property string $motivasi_berprestasi
 * @property string $inisiatif
 * @property string $sistematika_kerja
 * @property string $kkk
 * @property string $integritas_diri
 * @property string $loyalitas
 * @property string $stabilitas_emosi
 * @property string $pengendalian_diri
 * @property string $fleksibilitas
 * @property string $self_confidence
 * @property string $teamwork
 * @property string $penampilan_fisik
 * @property integer $total
 * @property string $rekomendasi
 * @property string $assessor_id
 * @property string $so_id
 * @property string $assessor_name
 * @property string $so_name
 * @property string $created_at
 * @property string $modified_at
 * @property string $status
 */
class CakimMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cakim_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['reg_no', 'psikotes_no', 'lokasi', 'nama', 'usia', 'jenis_kelamin', 'tingkat_pendidikan', 'prospek_jabatan', 'tanggal_pemeriksaan', 'kemampuan_umum', 'kemampuan_berfikir_analisa_sintesa', 'kemampuan_berfikir_konseptual', 'kemampuan_proses_belajar', 'motivasi_berprestasi', 'inisiatif', 'sistematika_kerja', 'kkk', 'integritas_diri', 'loyalitas', 'stabilitas_emosi', 'pengendalian_diri', 'fleksibilitas', 'self_confidence', 'teamwork', 'penampilan_fisik', 'rekomendasi', 'assessor_id', 'so_id', 'assessor_name', 'so_name', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reg_no' => Yii::t('app', 'Reg No'),
            'psikotes_no' => Yii::t('app', 'Psikotes No'),
            'lokasi' => Yii::t('app', 'Lokasi'),
            'nama' => Yii::t('app', 'Nama'),
            'usia' => Yii::t('app', 'Usia'),
            'jenis_kelamin' => Yii::t('app', 'Jenis Kelamin'),
            'tingkat_pendidikan' => Yii::t('app', 'Tingkat Pendidikan'),
            'prospek_jabatan' => Yii::t('app', 'Prospek Jabatan'),
            'tanggal_pemeriksaan' => Yii::t('app', 'Tanggal Pemeriksaan'),
            'kemampuan_umum' => Yii::t('app', 'Kemampuan Umum'),
            'kemampuan_berfikir_analisa_sintesa' => Yii::t('app', 'Kemampuan Berfikir Analisa Sintesa'),
            'kemampuan_berfikir_konseptual' => Yii::t('app', 'Kemampuan Berfikir Konseptual'),
            'kemampuan_proses_belajar' => Yii::t('app', 'Kemampuan Proses Belajar'),
            'motivasi_berprestasi' => Yii::t('app', 'Motivasi Berprestasi'),
            'inisiatif' => Yii::t('app', 'Inisiatif'),
            'sistematika_kerja' => Yii::t('app', 'Sistematika Kerja'),
            'kkk' => Yii::t('app', 'Kkk'),
            'integritas_diri' => Yii::t('app', 'Integritas Diri'),
            'loyalitas' => Yii::t('app', 'Loyalitas'),
            'stabilitas_emosi' => Yii::t('app', 'Stabilitas Emosi'),
            'pengendalian_diri' => Yii::t('app', 'Pengendalian Diri'),
            'fleksibilitas' => Yii::t('app', 'Fleksibilitas'),
            'self_confidence' => Yii::t('app', 'Self Confidence'),
            'teamwork' => Yii::t('app', 'Teamwork'),
            'penampilan_fisik' => Yii::t('app', 'Penampilan Fisik'),
            'total' => Yii::t('app', 'Total'),
            'rekomendasi' => Yii::t('app', 'Rekomendasi'),
            'assessor_id' => Yii::t('app', 'Assessor ID'),
            'so_id' => Yii::t('app', 'So ID'),
            'assessor_name' => Yii::t('app', 'Assessor Name'),
            'so_name' => Yii::t('app', 'So Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return CakimMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CakimMasterQuery(get_called_class());
    }
}
