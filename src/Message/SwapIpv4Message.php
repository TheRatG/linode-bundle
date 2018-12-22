<?php

namespace TheRat\LinodeBundle\Message;

class SwapIpv4Message
{
    /**
     * @var int
     */
    private $firstLinodeId;
    /**
     * @var int
     */
    private $secondLinodeId;

    public function __construct(int $firstLinodeId, int $secondLinodeId)
    {
        $this->firstLinodeId = $firstLinodeId;
        $this->secondLinodeId = $secondLinodeId;
    }

    /**
     * @return int
     */
    public function getFirstLinodeId(): int
    {
        return $this->firstLinodeId;
    }

    /**
     * @return int
     */
    public function getSecondLinodeId(): int
    {
        return $this->secondLinodeId;
    }
}