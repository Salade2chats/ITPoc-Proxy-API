<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;
use Phalcon\Text;

class Users extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $email */
    protected $email;
    /** @var string $password */
    protected $password;
    /** @var string $clearPassword */
    protected $clearPassword;
    /** @var string $token */
    protected $token;
    /** @var DateTime $creationDate */
    protected $creationDate;

    /**
     * @throws Exception
     * @return void
     */
    public function beforeValidationOnCreate()
    {
        $this->setId((new Random())->uuid());
        $this->setToken((new Random())->uuid());
        if (!$this->getPassword() && $this->getClearPassword()) {
            $this->setPassword($this->encryptPassword($this->getClearPassword()));
        }
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getClearPassword()
    {
        return $this->clearPassword;
    }

    /**
     * @param string $clearPassword
     * @return Users
     */
    public function setClearPassword($clearPassword)
    {
        $this->clearPassword = $clearPassword;
        return $this;
    }

    private function encryptPassword($clearPassword)
    {
        return $this->getDi()->getShared('security')->hash($clearPassword);
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
        $this->setSource("users");
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
     * @return Users
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Users
     */
    public function setToken($token)
    {
        $this->token = $token;
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
     * @return Users
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate->format("Y-m-d H:i:sP");
        return $this;
    }
}
