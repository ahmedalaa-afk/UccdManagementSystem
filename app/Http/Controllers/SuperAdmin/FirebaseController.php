<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials'))
            ->createMessaging();
    }
    // 🔹 Send to single device token
    public function sendToToken($token, $title, $body, array $data = [])
    {
        $message = CloudMessage::new()
            ->withTarget('token', $token)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        return $this->messaging->send($message);
    }

    // 🔹 Send to topic
    public function sendToTopic($topic, $title, $body, array $data = [])
    {
        $message = CloudMessage::new()
            ->withTarget('topic', $topic)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        return $this->messaging->send($message);
    }

    // 🔹 Send to multiple tokens
    public function sendMulticast(array $tokens, $title, $body, array $data = [])
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        return $this->messaging->sendMulticast($message, $tokens);
    }
}
