<?php

namespace TheRat\LinodeBundle\Aware;

use TheRat\LinodeBundle\LinodeClient;

interface LinodeClientAwareInterface
{
    public function getLinodeClient(): LinodeClient;

    public function setLinodeClient(LinodeClient $linodeClient);
}