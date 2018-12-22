<?php

namespace TheRat\LinodeBundle\Model\Instances;

use TheRat\LinodeBundle\Model\AbstractCollection;

class LinodeCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getObjectClassName()
    {
        return LinodeModel::class;
    }
}