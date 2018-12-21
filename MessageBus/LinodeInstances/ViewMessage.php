<?php

namespace TheRat\LinodeBundle\MessageBus\LinodeInstances;

class ViewMessage
{
    protected $linode;

    public function __construct(string $linode)
    {
        $this->linode = $linode;
    }

    /**
     * @return string
     */
    public function getLinode()
    {
        return $this->linode;
    }
}