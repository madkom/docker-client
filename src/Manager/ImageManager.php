<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.10.15
 * Time: 14:40
 */

namespace Madkom\Docker\Manager;

use GuzzleHttp\Client as HttpClient;
use Madkom\Docker\Http\Client as DockerHttpClient;

/**
 * Class ImageManager
 * @package Madkom\Docker
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class ImageManager
{
    /** @var HttpClient|DockerHttpClient */
    private $httpClient;

    /**
     * ImageManager constructor.
     * @param HttpClient|DockerHttpClient $httpClient
     */
    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }
}