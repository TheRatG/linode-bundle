<?php

namespace TheRat\LinodeBundle\Response;

class ErrorsResponse
{
    /**
     * @var ErrorResponse[]
     */
    protected $errors = [];

    public function addError(array $data)
    {
        $error = new ErrorResponse();
        $error->setField($data['field']);
        $error->setReason($data['reason']);
        $this->errors[] = $error;

        return $this;
    }
}