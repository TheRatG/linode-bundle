<?php

namespace TheRat\LinodeBundle\Message;

use TheRat\LinodeBundle\Model\Instances\LinodeModel;

class LinodeBootMessage
{
    /**
     * @var integer
     */
    protected $linodeId;

    /**
     * @var LinodeModel
     */
    protected $linode;

    public function __construct(int $linodeId)
    {
        $this->linodeId = $linodeId;
    }

    /**
     * @return int
     */
    public function getLinodeId(): int
    {
        return $this->linodeId;
    }

    /**
     * @return LinodeModel
     */
    public function getLinode(): ?LinodeModel
    {
        return $this->linode;
    }

    /**
     * @param LinodeModel $linode
     * @return LinodeBootMessage
     */
    public function setLinode(LinodeModel $linode): LinodeBootMessage
    {
        $this->linode = $linode;
        return $this;
    }
}