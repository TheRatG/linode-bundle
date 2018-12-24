<?php

namespace TheRat\LinodeBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use TheRat\LinodeBundle\Model\Instances\LinodeModel;

class BootLinodeEventArgs extends Event
{
    /**
     * @var LinodeModel
     */
    protected $linode;

    public function __construct(LinodeModel $linode)
    {
        $this->linode = $linode;
    }

    /**
     * @return LinodeModel
     */
    public function getLinode(): LinodeModel
    {
        return $this->linode;
    }
}