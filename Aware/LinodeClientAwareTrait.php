<?php

namespace TheRat\LinodeBundle\Aware;

use TheRat\LinodeBundle\LinodeClient;

trait LinodeClientAwareTrait
{
    /**
     * @var LinodeClient
     */
    protected $linodeClient;

    /**
     * @return LinodeClient
     */
    public function getLinodeClient(): LinodeClient
    {
        return $this->linodeClient;
    }

    /**
     * @param LinodeClient $linodeClient
     * @return LinodeClientAwareTrait
     */
    public function setLinodeClient(LinodeClient $linodeClient)
    {
        $this->linodeClient = $linodeClient;

        return $this;
    }
}