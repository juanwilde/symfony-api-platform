<?php

declare(strict_types=1);

namespace App\Http;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;

class FacebookClient
{
    private Facebook $client;

    /**
     * @throws FacebookSDKException
     */
    public function __construct(string $facebookClientId, string $facebookSecret, string $facebookGraphVersion)
    {
        $this->client = new Facebook([
            'app_id' => $facebookClientId,
            'app_secret' => $facebookSecret,
            'default_graph_version' => $facebookGraphVersion,
        ]);
    }

    /**
     * @throws FacebookSDKException
     */
    public function get(string $endpoint, string $token): FacebookResponse
    {
        return $this->client->get($endpoint, $token);
    }
}
