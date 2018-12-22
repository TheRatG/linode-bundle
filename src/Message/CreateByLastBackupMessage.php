<?php

namespace TheRat\LinodeBundle\Message;

use TheRat\LinodeBundle\Model\Instances\LinodeModel;

class CreateByLastBackupMessage
{
    /**
     * @var integer
     */
    protected $linodeId;
    /**
     * @var LinodeModel
     */
    protected $newLinode;

    public function __construct($linodeId)
    {
        $this->linodeId = $linodeId;
    }

    /**
     * @return integer
     */
    public function getLinodeId()
    {
        return $this->linodeId;
    }

    /**
     * @return LinodeModel
     */
    public function getNewLinode(): ?LinodeModel
    {
        return $this->newLinode;
    }

    /**
     * @param LinodeModel $newLinode
     * @return CreateByLastBackupMessage
     */
    public function setNewLinode(LinodeModel $newLinode): CreateByLastBackupMessage
    {
        $this->newLinode = $newLinode;
        return $this;
    }
}