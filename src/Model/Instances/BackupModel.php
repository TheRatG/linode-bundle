<?php

namespace TheRat\LinodeBundle\Model\Instances;

use TheRat\LinodeBundle\Model\AbstractModel;

class BackupModel extends AbstractModel
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var \DateTime
     */
    protected $created;
    /**
     * @var \DateTime
     */
    protected $updated;
    /**
     * @var \DateTime
     */
    protected $finished;
    /**
     * @var string
     */
    protected $label;
    /**
     * @var array
     */
    protected $configs;
    /**
     * @var array
     */
    protected $disks;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getFinished(): \DateTime
    {
        return $this->finished;
    }

    /**
     * @param \DateTime $finished
     */
    public function setFinished(\DateTime $finished): void
    {
        $this->finished = $finished;
    }

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

    /**
     * @param array $configs
     */
    public function setConfigs(array $configs): void
    {
        $this->configs = $configs;
    }

    /**
     * @return array
     */
    public function getDisks(): array
    {
        return $this->disks;
    }

    /**
     * @param array $disks
     */
    public function setDisks(array $disks): void
    {
        $this->disks = $disks;
    }
}