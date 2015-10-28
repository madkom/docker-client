<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.10.15
 * Time: 11:52
 */

namespace Madkom\Docker\Http;

use GuzzleHttp\Client as HttpClient;
use Madkom\Docker\Http\Handler\PeerNamedStreamHandler;
use RuntimeException;

/**
 * Class Client
 * @package Madkom\Docker\Http
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class Client extends HttpClient
{
    /**
     * Create a docker client from environement variables
     * @throw RuntimeException
     * @return Client
     */
    public static function createFromEnv()
    {
        $entrypoint = getenv('DOCKER_HOST') ? getenv('DOCKER_HOST') : 'unix:///var/run/docker.sock';

        if (getenv('DOCKER_TLS_VERIFY') && getenv('DOCKER_TLS_VERIFY') == 1) {
            if (!getenv('DOCKER_CERT_PATH')) {
                throw new RuntimeException('Connection to docker has been set to use TLS, but no PATH is defined for certificate in DOCKER_CERT_PATH docker environnement variable');
            }

            $cafile = getenv('DOCKER_CERT_PATH').DIRECTORY_SEPARATOR.'ca.pem';
            $certfile = getenv('DOCKER_CERT_PATH').DIRECTORY_SEPARATOR.'cert.pem';
            $keyfile = getenv('DOCKER_CERT_PATH').DIRECTORY_SEPARATOR.'key.pem';
            $peername = getenv('DOCKER_PEER_NAME') ? getenv('DOCKER_PEER_NAME') : 'boot2docker';
            return new self($entrypoint, true, $cafile, $certfile, $keyfile, $peername);
        }

        return new self($entrypoint);
    }

    /**
     * Client constructor.
     * @param string $entrypoint Docker API host uri
     * @param bool|false $useTls Should use TLS Verification
     * @param null $cafile Certificate Authority filename
     * @param null $certfile Certificate filename
     * @param null $keyfile Key filename
     * @param null $peername Peer name
     */
    public function __construct($entrypoint = 'unix:///var/run/docker.sock', $useTls = false, $cafile = null, $certfile = null, $keyfile = null, $peername = null)
    {
        $config = [
            'base_uri' => $entrypoint,
        ];

        if (true === $useTls) {
            $config = array_merge($config, $this->createSecureConfig($cafile, $certfile, $keyfile, $peername));
        }

        parent::__construct($config);
    }

    /**
     * Prepare secure configuration.
     * @param string $cafile Certificate Authority filename
     * @param string $certfile Certificate filename
     * @param string $keyfile Key filename
     * @param string $peername Peer name
     * @return array
     */
    private function createSecureConfig($cafile, $certfile, $keyfile, $peername)
    {
        $options = [
            'verify' => $cafile,
            'peer_name' => $peername,
            'handler' => new PeerNamedStreamHandler(),
        ];

        if (empty($keyfile)) {
            $options['cert'] = $certfile;
        } else {
            $fullcert = tempnam(sys_get_temp_dir(), 'docker-client-certfile');

            file_put_contents($fullcert, file_get_contents($certfile));
            file_put_contents($fullcert, file_get_contents($keyfile), FILE_APPEND);

            $options['cert'] = $fullcert;
        }

        return $options;
    }
}
