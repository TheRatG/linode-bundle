<?php

namespace TheRat\LinodeBundle\Model;

class ErrorModel
{
    /**
     * @var string
     */
    protected $reason;

    /**
     * @var string
     */
    protected $field;

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     * @return ErrorModel
     */
    public function setReason(string $reason): ErrorModel
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return ErrorModel
     */
    public function setField(string $field): ErrorModel
    {
        $this->field = $field;
        return $this;
    }
}