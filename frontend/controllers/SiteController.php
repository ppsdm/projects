<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use common\models\SignupForm;
use common\models\ContactForm;
use common\modules\core\models\Log;
//use frontend\modules\tao\models\TaoUriMap;
use common\models\User;
//use common\modules\tao\models\TaoUriMap;
//use common\modules\profile\models\UserCredit;
//use common\modules\profile\controller\Survey;
//use common\modules\assessment\models\AssessmentSearch;
//use common\modules\catalog\models\CatalogGeneral;
//use common\modules\assessment\models\Assessment;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;


use common\modules\profile\models\Profile;
use common\modules\profile\models\ProfileMeta;
      use yii\data\Sort;

/**
 * Site controller
 */
class SiteController extends \common\controllers\SiteController
{

    public $defaultAction = 'login';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

            return $this->render('index');
        
    }



    public function actionLang()
    {
        if (Yii::$app->language == 'en-US') {
                $lang = 'id-ID';
        } else {
                $lang = 'en-US';
        }
        Yii::$app->session->set('lang', $lang);

        $this->redirect(Yii::$app->request->referrer);

    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /*$paouser = TaoUriMap::find()->andWhere(['type' => 'user'])
                ->andWhere(['id' => Yii::$app->user->id])
                ->One();
$session = Yii::$app->session;
            $session->set('useruri', $paouser->uri);
            */

            return $this->redirect(['site/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }


        
    }

    public function actionLogin2()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if($model->login()) {
                          /*  $paouser = TaoUriMap::find()->andWhere(['type' => 'user'])
                ->andWhere(['id' => Yii::$app->user->id])
                ->One();
$session = Yii::$app->session;
            $session->set('useruri', $paouser->uri);
            */

            return $this->goBack();

            } else {
                        return $this->render('login', [
                'model' => $model,
            ]);
        }


        } 
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        
    }

    public function actionDebug()
    {
            return $this->render('debug', [
                
            ]);

    }
    public function actionInfo()
    {

        echo 'info';
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {


        Yii::$app->user->logout();
                            //echo Yii::$app->runAction('tao/tao/logout');
        //http://localhost:8090/gamantha/package-tao/taoDelivery/DeliveryServer/logout

            /*
                            $ch = curl_init($urlstring);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $useruri = curl_exec($ch);
                curl_close($ch);
                */

return $this->goHome();


//ONLY WHEN ALREADY USING TAO
$urlstring = Yii::$app->params['TAO_ROOT']."taoDelivery/PaodeliveryServer/paologout";
return $this->redirect($urlstring);
       // 
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionBugreport()
    {

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for reporting bugs.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('bugreport', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {

        return $this->render('about');
    }


public function actionTest()
{

    echo $type = Yii::$app->params['TAO_ROOT'] . Yii::$app->params['TESTTAKER_ROOT'];
}



    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '<br/><br/><br/><br/>Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
                $user = User::findByPasswordResetToken($token);
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
        

            Yii::$app->runAction('tao/tao/changepassword', ['userid' => $user->id, 'password' => $model->password]);
            Yii::$app->session->setFlash('success', '<br/><br/><br/><br/>New password was saved.');
            

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

public function beforeAction($action) {


  Log::add(Yii::$app->controller->id, $action->id,'activity');

    if (Yii::$app->session->has('lang')) {
        Yii::$app->language = Yii::$app->session->get('lang');
    } else {
        //or you may want to set lang session, this is just a sample
        //Yii::$app->language = 'us';
    }
    return parent::beforeAction($action);
}




    public function actionPublicresult($id, $uid){
/*
$this->getView()->registerMetaTag(['property' => 'og:url', 'content' => Url::current()]);
$this->getView()->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
$this->getView()->registerMetaTag(['property' => 'og:title', 'content' => 'Latihan Soal Online di SiapNgampus by EduLab']);
$this->getView()->registerMetaTag(['property' => 'og:description', 'content' => 'Latihan soal ujian di SiapNgampus dan lihat ranking kamu.']);
$this->getView()->registerMetaTag(['property' => 'og:image', 'content' => 'http://www.siapngampus.com/images/logo_edulab_200px.png']);
*/

    return $this->render('publicresult', ['id'=>$id, 'uid'=>$uid]);



    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

         $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                            $type = 'pao-user';
            # IF NOT USING TAO
            $add_user_result = true;
             //$add_user_result = Yii::$app->runAction('tao/adduser', ['userid' => $user->id, 'password' => $model->password, 'type' => $type]);

            if($add_user_result) {
             Yii::$app->session->setFlash('success', 'Signup Success!');
             //Yii::$app->session->setFlash('success', 'Signup Success! A verification email has been sent to you.');
                //if (Yii::$app->getUser()->login($user)) {
                //return $this->redirect('index');
             return $this->goHome();
                //}
            } else {
                Yii::$app->session->setFlash('danger', 'User is created but not registered to TAO');
            }

                            
                        }


                    }

                    return $this->render('signup', [
                        'model' => $model,
                    ]);




    }
    



}

