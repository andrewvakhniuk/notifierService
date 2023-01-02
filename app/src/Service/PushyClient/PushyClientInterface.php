<?php

namespace App\Service\PushyClient;

interface PushyClientInterface
{
    public function sendPushNotification(string $token, string $message): void;
}