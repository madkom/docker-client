<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.10.15
 * Time: 14:56
 */

namespace Madkom\Docker\Manager;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use Madkom\Docker\Http\Client as DockerHttpClient;

/**
 * Class HostManager
 * @package Madkom\Docker\Manager
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class HostManager
{
    /** @var HttpClient|DockerHttpClient */
    private $httpClient;

    /**
     * HostManager constructor.
     * @param HttpClient|DockerHttpClient $httpClient
     */
    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Show the docker components version information
     * @return array json object with version values
     */
    public function getVersion()
    {
        try {
            $response = $this->httpClient->get(['/version', []]);
        } catch (RequestException $e) {
            throw $e;
        }

        return $response->json();
    }
}
