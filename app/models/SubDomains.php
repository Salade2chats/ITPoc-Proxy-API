<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;

class SubDomains extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $subDomain */
    protected $subDomain;
    /** @var string $userId */
    protected $userId;
    /** @var string $domainId */
    protected $domainId;
    /** @var DateTime $creationDate */
    protected $creationDate;

    /**
     * @throws Exception
     * @return void
     */
    public function beforeValidationOnCreate()
    {
        $this->setId((new Random())->uuid());
    }

    /**
     * @return void
     */
    public function beforeCreate()
    {
        $creationDate = (new DateTime())->setTimezone(new DateTimeZone("UTC"));
        $this->setCreationDate($creationDate);
    }

    public function initialize()
    {
        $this->setSource("sub_domains");
        $this->belongsTo(
            'userId',
            Users::class,
            'id',
            [
                'foreignKey' => true
            ]
        );
        $this->belongsTo(
            'domainId',
            Domains::class,
            'id',
            [
                'foreignKey' => true
            ]
        );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SubDomains
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubDomain()
    {
        return $this->subDomain;
    }

    /**
     * @param string $subDomain
     * @return SubDomains
     */
    public function setSubDomain($subDomain)
    {
        $this->subDomain = $subDomain;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return SubDomains
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomainId()
    {
        return $this->domainId;
    }

    /**
     * @param string $domainId
     * @return SubDomains
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate ? new DateTime($this->creationDate) : null;
    }

    /**
     * @param DateTime $creationDate
     * @return SubDomains
     */
    public function setCreationDate(DateTime $creationDate)
    {
        $this->creationDate = $creationDate->format("Y-m-d H:i:sP");
        return $this;
    }
}
