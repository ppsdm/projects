<?php

namespace common\controllers;
use common\models\Notification;

use Yii;

class MessageController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest($id)
    {
    	// $message was just created by the logged in user, and sent to $recipient_id
Notification::notify(Notification::KEY_NEW_MESSAGE, Yii::$app->user->id, $id);
//Notification::warning(Notification::KEY_NEW_MESSAGE, '52', 1);

// You may also use the following static methods to set the notification type:
//Notification::warning(Notification::KEY_NEW_MESSAGE, $recipient_id, $message->id);
//Notification::success(Notification::ORDER_PLACED, $admin_id, $order->id);
//Notification::error(Notification::KEY_NO_DISK_SPACE, $admin_id);
    }

}
