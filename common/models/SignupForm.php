<?php
namespace common\models;

use yii\base\Model;
use common\models\User;
use common\modules\profile\models\ProfileMeta;
use common\modules\profile\models\Profile;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
        public $birthdate;
        public $gender;
    //public $current_ed_level;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['first_name', 'trim'],
            ['first_name', 'string', 'min' => 0, 'max' => 255],

            ['last_name', 'trim'],
            ['last_name', 'string', 'min' => 0, 'max' => 255],

          //  ['current_ed_level', 'string'],
            ['gender', 'string'],
            ['birthdate', 'date','format' => 'php:Y-m-d'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
                ['password', 'match', 'pattern' => '/^[a-z][a-z0-9_.]*$/', 'message' => 'password is invalid. password have to be min 6 lowercase alphanumeric and underscore'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();


        $result = $user->save();
        /*
        $profile_edulab = new ProfileMeta;
        $profile_general = new Profile;


                $profile_general->first_name = $this->first_name;
        $profile_general->last_name = $this->last_name;
        $profile_general->birthdate = $this->birthdate;
        $profile_general->gender = $this->gender;
                $profile_general->user_id = $user->id;
                $result = $profile_general->save();


                $profile_edulab->user_id = $user->id;
                $profile_edulab->type = 'edulab';
                $profile_edulab->key = 'ed_level';
                $profile_edulab->value = $this->current_ed_level;
                $result = $profile_edulab->save();
                

$email_message = 'COngrats';

        Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom(['admin' => 'Admin'])
            ->setSubject('Signup')
            ->setTextBody($email_message)
            ->send();
*/

        
        return $result ? $user : null;
    }
}
