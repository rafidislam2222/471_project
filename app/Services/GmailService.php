<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Support\Facades\Storage;

class GmailService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        // Point to the credentials you downloaded
        $this->client->setAuthConfig(storage_path('app/google-credentials.json'));
        $this->client->setAccessType('offline'); // Important for refreshing tokens
        $this->client->addScope(Gmail::GMAIL_SEND);
    }

    public function connect()
    {
        // Check if we have a token saved
        if (Storage::exists('gmail-token.json')) {
            $accessToken = json_decode(Storage::get('gmail-token.json'), true);
            $this->client->setAccessToken($accessToken);
        }

        // If token is expired, refresh it
        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                Storage::put('gmail-token.json', json_encode($this->client->getAccessToken()));
            } else {
                // If we don't have a refresh token, we need to login again
                return false; 
            }
        }
        return true;
    }

    public function getLoginUrl()
    {
        // Generate the URL for you to click and login
        $this->client->setRedirectUri('http://127.0.0.1:8000/gmail/callback');
        return $this->client->createAuthUrl();
    }

    public function saveToken($code)
    {
        $this->client->setRedirectUri('http://127.0.0.1:8000/gmail/callback');
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
        Storage::put('gmail-token.json', json_encode($accessToken));
    }

    public function sendEmail($to, $subject, $body)
    {
        $service = new Gmail($this->client);
        
        // Create the email content (Raw Base64 encoded)
        $rawMessageString = "From: me\r\n";
        $rawMessageString .= "To: $to\r\n";
        $rawMessageString .= "Subject: $subject\r\n\r\n";
        $rawMessageString .= "$body";
        
        $rawMessage = base64_encode($rawMessageString);
        $rawMessage = str_replace(['+', '/', '='], ['-', '_', ''], $rawMessage); // URL Safe fix

        $msg = new Message();
        $msg->setRaw($rawMessage);
        
        $service->users_messages->send('me', $msg);
    }
}