<?php

namespace TheRat\LinodeBundle\Model\Instances;

use TheRat\LinodeBundle\Model\AbstractModel;

class LinodeModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $label;
    /**
     * @var string
     */
    protected $region;
    /**
     * @var string
     */
    protected $image;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $group;
    /**
     * @var array
     */
    protected $tags;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var string
     */
    protected $hypervisor;
    /**
     * @var \DateTime
     */
    protected $created;
    /**
     * @var \DateTime
     */
    protected $updated;
    /**
     * @var string[]
     */
    protected $ipv4;
    /**
     * @var string
     */
    protected $ipv6;
    /**
     * @var string
     */
    protected $specs;
    /**
     * @var array
     */
    protected $alerts;
    /**
     * @var array
     */
    protected $backups;
    /**
     * @var boolean
     */
    protected $watchdogEnabled;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return LinodeModel
     */
    public function setLabel(string $label): LinodeModel
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     * @return LinodeModel
     */
    public function setRegion(string $region): LinodeModel
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return LinodeModel
     */
    public function setImage(string $image): LinodeModel
    {
        $this->image = $image;
        return $this;
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
     * @return LinodeModel
     */
    public function setType(string $type): LinodeModel
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return LinodeModel
     */
    public function setGroup(string $group): LinodeModel
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return LinodeModel
     */
    public function setTags(array $tags): LinodeModel
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return LinodeModel
     */
    public function setId(int $id): LinodeModel
    {
        $this->id = $id;
        return $this;
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
     * @return LinodeModel
     */
    public function setStatus(string $status): LinodeModel
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getHypervisor(): string
    {
        return $this->hypervisor;
    }

    /**
     * @param string $hypervisor
     * @return LinodeModel
     */
    public function setHypervisor(string $hypervisor): LinodeModel
    {
        $this->hypervisor = $hypervisor;
        return $this;
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
     * @return LinodeModel
     */
    public function setCreated(\DateTime $created): LinodeModel
    {
        $this->created = $created;
        return $this;
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
     * @return LinodeModel
     */
    public function setUpdated(\DateTime $updated): LinodeModel
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getIpv4(): array
    {
        return $this->ipv4;
    }

    /**
     * @param string[] $ipv4
     * @return LinodeModel
     */
    public function setIpv4(array $ipv4): LinodeModel
    {
        $this->ipv4 = $ipv4;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpv6(): string
    {
        return $this->ipv6;
    }

    /**
     * @param string $ipv6
     * @return LinodeModel
     */
    public function setIpv6(string $ipv6): LinodeModel
    {
        $this->ipv6 = $ipv6;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpecs(): string
    {
        return $this->specs;
    }

    /**
     * @param string $specs
     * @return LinodeModel
     */
    public function setSpecs(string $specs): LinodeModel
    {
        $this->specs = $specs;
        return $this;
    }

    /**
     * @return array
     */
    public function getAlerts(): array
    {
        return $this->alerts;
    }

    /**
     * @param array $alerts
     * @return LinodeModel
     */
    public function setAlerts(array $alerts): LinodeModel
    {
        $this->alerts = $alerts;
        return $this;
    }

    /**
     * @return array
     */
    public function getBackups(): array
    {
        return $this->backups;
    }

    /**
     * @param array $backups
     * @return LinodeModel
     */
    public function setBackups(array $backups): LinodeModel
    {
        $this->backups = $backups;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWatchdogEnabled(): bool
    {
        return $this->watchdogEnabled;
    }

    /**
     * @param bool $watchdogEnabled
     * @return LinodeModel
     */
    public function setWatchdogEnabled(bool $watchdogEnabled): LinodeModel
    {
        $this->watchdogEnabled = $watchdogEnabled;
        return $this;
    }
}