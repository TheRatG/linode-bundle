<?php

namespace TheRat\LinodeBundle\Model\Instances;

use TheRat\LinodeBundle\Model\AbstractCollection;

class BackupCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getObjectClassName()
    {
        return BackupModel::class;
    }
}