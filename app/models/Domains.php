<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;
use Phalcon\Text;

class Domains extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $domain */
    protected $domain;
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
        $this->setSource("domains");
    }

    /**
     * @return array
     */
    public function columnMap()
    {
        $columns = $this->getModelsMetaData()->getAttributes($this);
        $map = [];
        foreach ($columns as $column) $map[$column] = lcfirst(Text::camelize($column));
        return $map;
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
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return Domains
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
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
