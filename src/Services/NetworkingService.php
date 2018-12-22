<?php

namespace TheRat\LinodeBundle\Services;

use TheRat\LinodeBundle\Aware\LinodeClientAwareInterface;
use TheRat\LinodeBundle\Aware\LinodeClientAwareTrait;

class NetworkingService implements LinodeClientAwareInterface
{
    use LinodeClientAwareTrait;


}