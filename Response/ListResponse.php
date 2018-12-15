<?php

namespace TheRat\LinodeBundle\Response;

class ListResponse
{
    protected $page;
    protected $pages;
    protected $data;
    private $results;

    public function __construct(array $data, $page, $pages, $results)
    {
        $this->page = $page;
        $this->pages = $pages;
        $this->results = $results;

        $this->data = [];
        foreach ($data as $item) {
            $this->data[] = new ItemResponse($item);
        }
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return integer
     */
    public function getResults()
    {
        return $this->results;
    }
}