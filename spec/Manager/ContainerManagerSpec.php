<?php

namespace spec\Madkom\Docker\Manager;

use Madkom\Docker\Http\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContainerManagerSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\Docker\Manager\ContainerManager');
    }
}
