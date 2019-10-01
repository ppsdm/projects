<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\KemenkesActivity;

/**
 * KemenkesActivitySearch represents the model behind the search form of `frontend\models\KemenkesActivity`.
 */
class KemenkesActivitySearch extends KemenkesActivity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'assessee_id', 'assessor_id', 'second_opinion_id', 'integritas_lki', 'kerjasama_lki', 'komunikasi_lki', 'orientasihasil_lki', 'pelayananpublik_lki', 'pengembangandiri_lki', 'pengelolaanperubahan_lki', 'pengambilankeputusan_lki', 'perekatbangsa_lki', 'psikogram_kemampuananalisa', 'psikogram_empati', 'psikogram_kemampuanumum', 'psikogram_kemampuanbelajar', 'psikogram_ketekunan', 'psikogram_ketelitian', 'psikogram_komunikasiefektif', 'psikogram_konsepdiri', 'psikogram_logikaberpikir', 'psikogram_motivasi', 'psikogram_pemahamansosial', 'psikogram_kematanganemosi', 'psikogram_sistematikakerja', 'psikogram_tempokerja', 'psikogram_inisiatif', 'psikogram_adaptif'], 'integer'],
            [['no_test', 'tanggal_test', 'tempat_test', 'tujuan_pemeriksaan', 'saran', 'executive_summary', 'kekuatan', 'kelemahan', 'integritas_uraian', 'kerjasama_uraian', 'komunikasi_uraian', 'orientasihasil_uraian', 'pelayananpublik_uraian', 'pengembangandiri_uraian', 'pengelolaanperubahan_uraian', 'pengambilankeputusan_uraian', 'perekatbangsa_uraian', 'integritas_indikator', 'kerjasama_indikator', 'komunikasi_indikator', 'orientasihasil_indikator', 'pelayananpublik_indikator', 'pengembangandiri_indikator', 'pengelolaanperubahan_indikator', 'pengambilankeputusan_indikator', 'perekatbangsa_indikator', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = KemenkesActivity::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'assessee_id' => $this->assessee_id,
            'assessor_id' => $this->assessor_id,
            'second_opinion_id' => $this->second_opinion_id,
            'tanggal_test' => $this->tanggal_test,
            'integritas_lki' => $this->integritas_lki,
            'kerjasama_lki' => $this->kerjasama_lki,
            'komunikasi_lki' => $this->komunikasi_lki,
            'orientasihasil_lki' => $this->orientasihasil_lki,
            'pelayananpublik_lki' => $this->pelayananpublik_lki,
            'pengembangandiri_lki' => $this->pengembangandiri_lki,
            'pengelolaanperubahan_lki' => $this->pengelolaanperubahan_lki,
            'pengambilankeputusan_lki' => $this->pengambilankeputusan_lki,
            'perekatbangsa_lki' => $this->perekatbangsa_lki,
            'psikogram_kemampuananalisa' => $this->psikogram_kemampuananalisa,
            'psikogram_empati' => $this->psikogram_empati,
            'psikogram_kemampuanumum' => $this->psikogram_kemampuanumum,
            'psikogram_kemampuanbelajar' => $this->psikogram_kemampuanbelajar,
            'psikogram_ketekunan' => $this->psikogram_ketekunan,
            'psikogram_ketelitian' => $this->psikogram_ketelitian,
            'psikogram_komunikasiefektif' => $this->psikogram_komunikasiefektif,
            'psikogram_konsepdiri' => $this->psikogram_konsepdiri,
            'psikogram_logikaberpikir' => $this->psikogram_logikaberpikir,
            'psikogram_motivasi' => $this->psikogram_motivasi,
            'psikogram_pemahamansosial' => $this->psikogram_pemahamansosial,
            'psikogram_kematanganemosi' => $this->psikogram_kematanganemosi,
            'psikogram_sistematikakerja' => $this->psikogram_sistematikakerja,
            'psikogram_tempokerja' => $this->psikogram_tempokerja,
            'psikogram_inisiatif' => $this->psikogram_inisiatif,
            'psikogram_adaptif' => $this->psikogram_adaptif,
        ]);

        $query->andFilterWhere(['like', 'no_test', $this->no_test])
            ->andFilterWhere(['like', 'tempat_test', $this->tempat_test])
            ->andFilterWhere(['like', 'tujuan_pemeriksaan', $this->tujuan_pemeriksaan])
            ->andFilterWhere(['like', 'saran', $this->saran])
            ->andFilterWhere(['like', 'executive_summary', $this->executive_summary])
            ->andFilterWhere(['like', 'kekuatan', $this->kekuatan])
            ->andFilterWhere(['like', 'kelemahan', $this->kelemahan])
            ->andFilterWhere(['like', 'integritas_uraian', $this->integritas_uraian])
            ->andFilterWhere(['like', 'kerjasama_uraian', $this->kerjasama_uraian])
            ->andFilterWhere(['like', 'komunikasi_uraian', $this->komunikasi_uraian])
            ->andFilterWhere(['like', 'orientasihasil_uraian', $this->orientasihasil_uraian])
            ->andFilterWhere(['like', 'pelayananpublik_uraian', $this->pelayananpublik_uraian])
            ->andFilterWhere(['like', 'pengembangandiri_uraian', $this->pengembangandiri_uraian])
            ->andFilterWhere(['like', 'pengelolaanperubahan_uraian', $this->pengelolaanperubahan_uraian])
            ->andFilterWhere(['like', 'pengambilankeputusan_uraian', $this->pengambilankeputusan_uraian])
            ->andFilterWhere(['like', 'perekatbangsa_uraian', $this->perekatbangsa_uraian])
            ->andFilterWhere(['like', 'integritas_indikator', $this->integritas_indikator])
            ->andFilterWhere(['like', 'kerjasama_indikator', $this->kerjasama_indikator])
            ->andFilterWhere(['like', 'komunikasi_indikator', $this->komunikasi_indikator])
            ->andFilterWhere(['like', 'orientasihasil_indikator', $this->orientasihasil_indikator])
            ->andFilterWhere(['like', 'pelayananpublik_indikator', $this->pelayananpublik_indikator])
            ->andFilterWhere(['like', 'pengembangandiri_indikator', $this->pengembangandiri_indikator])
            ->andFilterWhere(['like', 'pengelolaanperubahan_indikator', $this->pengelolaanperubahan_indikator])
            ->andFilterWhere(['like', 'pengambilankeputusan_indikator', $this->pengambilankeputusan_indikator])
            ->andFilterWhere(['like', 'perekatbangsa_indikator', $this->perekatbangsa_indikator])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
