<?php

namespace App\Services;

use Illuminate\Notifications\Notification;
use OneSignal;

class OneSignalNotification extends Notification
{
    public static function send($fields,$message){
       $notif =  OneSignal::sendPush($fields, $message);
        return $notif;
    }

    public static function createSegment($fields){
        $notif = OneSignal::createSegment($fields);
        return $notif;
    }

    public static function _send($data,){
        //$data['type'] = 1;
        //$data['content'] = new BonAchatResource($bon);
       // $fields['include_external_user_ids'] = ['b4843a1242651320421522ed9d6108f135b19128'];
        //$fields['channel_for_external_user_ids'] = "push";
       // $fields['isAndroid'] = true;
       // $fields['data'] = $data;
       // $message = 'Nouveau Bon Casino!';
       // $notif =  OneSignal::sendPush($fields, $message);
      //  return response()->json($notif);
    }

    /*
    public function sendNotifications()
    {
        try {
            $users = User::where('id','>','200')->get();
            foreach ($users as $user) {
                $userId = $user->user_id;
                $oneSignalId = $user->onesignal_user_id;

                $availablePushNotifications = $this->notificationRepository->getPushNotifications($userId);
                if($availablePushNotifications === 'false') {
                    return response("Invalid user",1002);
                }

                if (!empty($availablePushNotifications)) {
                    foreach ($availablePushNotifications as $pushNotification) {
                        $contentMsg = $pushNotification->notification;
                        $sendPushNotifications = $this->commonService->sendOneSignalNotifications($contentMsg, $oneSignalId);
                        $sendPushNotificationRes = json_decode($sendPushNotifications);
                        if(isset($sendPushNotificationRes->errors) && !empty($sendPushNotificationRes->errors)) {
                            return response($sendPushNotificationRes->errors,1002);
                        }
                        print $sendPushNotifications;
                    }
                }
            }
            return 'Successfully sent!';
        } catch (Exception $e) {
            Log::error($e);
            return new FailResponse(($e->getCode() ? $e->getCode() : 500), "Could not Load");
        }
    }
    */
}
