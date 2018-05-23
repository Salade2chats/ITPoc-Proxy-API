<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;

class SubDomain extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $subdomain */
    protected $subdomain;
    /** @var string $user_id */
    protected $user_id;
    /** @var string $domain_id */
    protected $domain_id;
    /** @var DateTime $creation_date */
    protected $creation_date;

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
        $this->setSource("user_domain");
        $this->belongsTo(
            'user_id',
            User::class,
            'id',
            [
                'foreignKey' => true
            ]
        );
        $this->belongsTo(
            'domain_id',
            Domain::class,
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
     * @return SubDomain
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    /**
     * @param string $subdomain
     * @return SubDomain
     */
    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     * @return SubDomain
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomainId()
    {
        return $this->domain_id;
    }

    /**
     * @param string $domain_id
     * @return SubDomain
     */
    public function setDomainId($domain_id)
    {
        $this->domain_id = $domain_id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creation_date ? new DateTime($this->creation_date) : null;
    }

    /**
     * @param DateTime $creation_date
     * @return Domain
     */
    public function setCreationDate(DateTime $creation_date)
    {
        $this->creation_date = $creation_date->format("Y-m-d H:i:sP");
        return $this;
    }
}
