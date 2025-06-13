<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory)
            ->withServiceAccount(config('firebase.projects.app.credentials'))
            ->createMessaging();
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        try {
            $message = CloudMessage::new()
                ->withTarget('token', $token)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            Log::error("FCM Token Error: " . $e->getMessage());
            return false;
        }
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        try {
            $message = CloudMessage::new()
                ->withTarget('topic', $topic)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            Log::error("FCM Topic Error: " . $e->getMessage());
            return false;
        }
    }

    public function sendMulticast(array $tokens, string $title, string $body, array $data = []): array
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        $report = $this->messaging->sendMulticast($message, $tokens);

        return [
            'success' => $report->successes()->count(),
            'failure' => $report->failures()->count()
        ];
    }
}
