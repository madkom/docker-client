<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.10.15
 * Time: 14:25
 */

namespace Madkom\Docker;

use GuzzleHttp\Client as HttpClient;
use Madkom\Docker\Http\Client as DockerHttpClient;
use Madkom\Docker\Manager\ContainerManager;
use Madkom\Docker\Manager\HostManager;
use Madkom\Docker\Manager\ImageManager;

/**
 * Class Client
 * @package Madkom\Docker
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Client
{
    /** @var HttpClient|DockerHttpClient */
    private $httpClient;
    /** @var ContainerManager */
    private $containerManager;
    /** @var ImageManager */
    private $imageManager;
    /** @var HostManager */
    private $hostManager;

    /**
     * Client constructor.
     * @param HttpClient|null $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?: DockerHttpClient::createFromEnv();
    }

    /**
     * Create and return ContainerManager instance
     * @return ContainerManager
     */
    public function getContainerManager()
    {
        if (null === $this->containerManager) {
            $this->containerManager = new ContainerManager($this->httpClient);
        }

        return $this->containerManager;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        if (null === $this->imageManager) {
            $this->imageManager = new ImageManager($this->httpClient);
        }

        return $this->imageManager;
    }

    /**
     * @return HostManager
     */
    public function getHostManager()
    {
        if (null === $this->hostManager) {
            $this->hostManager = new HostManager($this->httpClient);
        }

        return $this->hostManager;
    }

}
