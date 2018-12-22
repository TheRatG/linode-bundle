<?php

namespace TheRat\LinodeBundle\Response;

class ErrorResponse
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
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     * @return ErrorResponse
     */
    public function setReason(?string $reason): ErrorResponse
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return ErrorResponse
     */
    public function setField(?string $field): ErrorResponse
    {
        $this->field = $field;
        return $this;
    }
}