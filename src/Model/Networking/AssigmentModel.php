<?php

namespace TheRat\LinodeBundle\Model\Networking;

use TheRat\LinodeBundle\Model\AbstractModel;

class AssigmentModel extends AbstractModel
{
    /**
     * @var integer
     */
    protected $linodeId;

    /**
     * @var string
     */
    protected $address;

    /**
     * @return int
     */
    public function getLinodeId(): int
    {
        return $this->linodeId;
    }

    /**
     * @param int $linodeId
     * @return AssigmentModel
     */
    public function setLinodeId(int $linodeId): AssigmentModel
    {
        $this->linodeId = $linodeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return AssigmentModel
     */
    public function setAddress(string $address): AssigmentModel
    {
        $this->address = $address;
        return $this;
    }
}