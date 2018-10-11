<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $organization_id
 * @property string $name
 * @property string $status
 *
 * @property Activity[] $activities
 * @property Assessment[] $assessments
 * @property Organization $organization
        * @property string $description
 * @property ProjectMeta[] $projectMetas
 * @property UserProjectRole[] $userProjectRoles
 */
class AssessmentReport extends \yii\db\ActiveRecord
{

    public $executive_summary;
    public $first_name;
    public $kekuatan;
    public $current_position;
    public $satuan_kerja;
    public $kelemahan;
    public $saran_pengembangan;
    public $alamat;
    public $pendidikan_terakhir;
	public $indikator;
	public $integritas;
	public $integritas_lki;
	public $kerjasama;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['executive_summary', 'trim'],
            //['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['executive_summary', 'string', 'min' => 0],
            ['kekuatan', 'trim'],
            ['kekuatan', 'string', 'min' => 0],
            ['integritas', 'trim'],
            ['integritas', 'string', 'min' => 0],
            ['kerjasama', 'trim'],
            ['kerjasama', 'string', 'min' => 0],
            ['first_name', 'trim'],
            ['first_name', 'string', 'max' => 255],
            ['kelemahan', 'trim'],
            ['kelemahan', 'string', 'min' => 0],
            ['saran_pengembangan', 'trim'],
            ['saran_pengembangan', 'string', 'min' => 0],
            [['alamat', 'pendidikan_terakhir', 'current_position', 'satuan_kerja'], 'string'],
        ];
    }



}
