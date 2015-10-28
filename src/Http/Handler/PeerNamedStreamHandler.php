<?php
/**
 * Created by PhpStorm.
 * User: mbrzuchalski
 * Date: 28.10.15
 * Time: 12:40
 */

namespace Madkom\Docker\Http\Handler;

use GuzzleHttp\Handler\StreamHandler;
use Psr\Http\Message\RequestInterface;

/**
 * Class SecuredConnectorWithTlsVerification
 * @package Madkom\Docker\Socket
 * @author Michał Brzuchalski <m.brzuchalski@madkom.pl>
 */
class PeerNamedStreamHandler extends StreamHandler
{
    private function add_peer_name(RequestInterface $request, &$options, $value, &$params)
    {
        $options['ssl']['peer_name'] = $value;
    }
}