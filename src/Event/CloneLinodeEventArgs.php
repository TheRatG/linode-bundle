<?php

namespace TheRat\LinodeBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use TheRat\LinodeBundle\Model\Instances\LinodeModel;

class CloneLinodeEventArgs extends Event
{
    /**
     * @var LinodeModel
     */
    protected $linode;
    /**
     * @var LinodeModel
     */
    protected $newLinode;

    public function __construct(LinodeModel $linode, LinodeModel $newLinode = null)
    {
        $this->linode = $linode;
        $this->newLinode = $newLinode;
    }

    /**
     * @return LinodeModel
     */
    public function getLinode(): LinodeModel
    {
        return $this->linode;
    }

    /**
     * @return LinodeModel
     */
    public function getNewLinode(): LinodeModel
    {
        return $this->newLinode;
    }
}