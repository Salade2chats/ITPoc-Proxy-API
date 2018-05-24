<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;

class Domains extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $name */
    protected $name;
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
        $this->setSource("domain");
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
     * @return Domains
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Domains
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Domains
     */
    public function setCreationDate(DateTime $creationDate)
    {
        $this->creationDate = $creationDate->format("Y-m-d H:i:sP");
        return $this;
    }
}
