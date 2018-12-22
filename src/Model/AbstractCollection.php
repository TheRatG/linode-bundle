<?php

namespace TheRat\LinodeBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractCollection extends ArrayCollection
{
    protected $page;

    protected $pages;

    protected $results;

    /**
     * AbstractDefinitionCollection constructor.
     * @param array $elements
     * @param int $page
     * @param int|null $pages
     * @param int|null $results
     */
    public function __construct(array $elements = [], int $page = 1, int $pages = null, int $results = null)
    {
        $this->page = $page;
        $this->pages = $pages;
        $this->results = $results;

        $objects = [];
        foreach ($elements as $element) {
            $objectClassName = $this->getObjectClassName();
            if ($element instanceof $objectClassName) {
                $objects[] = $element;
            } elseif (is_array($element)) {
                $object = new $objectClassName();
                if ($object instanceof AbstractModel) {
                    $object->populate($element);
                    $objects[] = $object;
                } else {
                    throw new \RuntimeException('Object must extend AbstractModel');
                }
            } else {
                throw new \InvalidArgumentException('Invalid element');
            }
        }

        parent::__construct($objects);
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int|null
     */
    public function getPages(): ?int
    {
        return $this->pages;
    }

    /**
     * @return int|null
     */
    public function getResults(): ?int
    {
        return $this->results;
    }

    public function toArray()
    {
        $result = [];
        foreach (parent::toArray() as $key => $value) {
            /** @var AbstractModel $value */
            $result[$key] = $value->toArray();
        }

        return $result;
    }

    /**
     * @return string
     */
    abstract public function getObjectClassName();
}