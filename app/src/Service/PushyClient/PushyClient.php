<?php

namespace App\Service\PushyClient;

/**
 * Partially the implementation was copied from Pushy documentation
 *
 * @todo Requires grooming
 */
class PushyClient implements PushyClientInterface
{
    public function __construct(private readonly string $apiKey)
    {
    }

    /**
     * @throws \Exception
     */
    public function sendPushNotification(string $token, string $message): void
    {
        $data = array('message' => $message);

        $to = array($token);

        $options = array(
            'notification' => array(
                'badge' => 1,
                'sound' => 'ping.aiff',
                'title' => 'Test Notification',
                'body'  => $message
            )
        );

        $this->sendPushNotificationRequest($data, $to, $options);
    }

    /**
     * @throws \Exception
     */
    protected function sendPushNotificationRequest(array $data, array $to, array $options): void
    {
        // Default post data to provided options or empty array
        $post = $options ?: array();

        // Set notification payload and recipients
        $post['to'] = $to;
        $post['data'] = $data;

        // Set Content-Type header since we're sending JSON
        $headers = array(
            'Content-Type: application/json'
        );

        // Initialize curl handle
        $ch = curl_init();

        // Set URL to Pushy endpoint
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushy.me/push?api_key=' . $this->apiKey);

        // Set request method to POST
        curl_setopt($ch, CURLOPT_POST, true);

        // Set our custom headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response back as string instead of printing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set post data as JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post, JSON_UNESCAPED_UNICODE));

        // Actually send the push
        $result = curl_exec($ch);

        // Display errors
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }

        // Close curl handle
        curl_close($ch);

        // Attempt to parse JSON response
        $response = @json_decode($result);

        // Throw if JSON error returned
        if (isset($response) && isset($response->error)) {
            throw new \Exception('Pushy API returned an error: ' . $response->error);
        }
    }
}