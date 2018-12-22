<?php

namespace TheRat\LinodeBundle\Model\Networking;

use TheRat\LinodeBundle\Model\AbstractCollection;

class AssigmentCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getObjectClassName()
    {
        return AssigmentModel::class;
    }
}