<?php

namespace Gabievi\LaravelSMSOffice;

use DomainException;
use GuzzleHttp\Client as HttpClient;

class SMSOffice
{
    /** @var string */
    protected $apiUrl = 'http://smsoffice.ge/api/v2/send';

    /** @var HttpClient */
    protected $httpClient;

    /** @var string */
    protected $key;

    /** @var string */
    protected $sender;

    //
    public function __construct($key, $sender)
    {
        $this->key = $key;
        $this->sender = $sender;

        $this->httpClient = new HttpClient([
            'timeout'         => 5,
            'connect_timeout' => 5,
        ]);
    }

    //
    public function send($params)
    {
        $base = [
            'key'    => urlencode($this->key),
            'sender' => urlencode($this->sender),
        ];

        $params = array_merge($params, $base);
        $url = $this->apiUrl.'?'.http_build_query($params);

        $response = $this->httpClient->get($url);
        $response = json_decode((string) $response->getBody(), true);

        if (isset($response['ErrorCode']) && (int) $response['ErrorCode'] !== 0) {
            throw new DomainException($response['Message'], $response['ErrorCode']);
        }
    }
}
