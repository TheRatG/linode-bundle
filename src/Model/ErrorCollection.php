<?php

namespace TheRat\LinodeBundle\Model;

class ErrorCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getObjectClassName()
    {
        return ErrorModel::class;
    }
}