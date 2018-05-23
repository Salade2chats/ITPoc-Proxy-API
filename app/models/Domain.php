<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;

class Domain extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $name */
    protected $name;
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
     * @return Domain
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
     * @return Domain
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
