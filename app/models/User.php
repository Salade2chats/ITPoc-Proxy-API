<?php

namespace ITPocProxy\Model;

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model;
use Phalcon\Security\Exception;
use Phalcon\Security\Random;

class User extends Model
{
    /** @var string $id */
    protected $id;
    /** @var string $email */
    protected $email;
    /** @var string $password */
    protected $password;
    /** @var string $clear_password */
    protected $clear_password;
    /** @var string $token */
    protected $token;
    /** @var DateTime $creation_date */
    protected $creation_date;

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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
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
        return $this->clear_password;
    }

    /**
     * @param string $clear_password
     * @return User
     */
    public function setClearPassword($clear_password)
    {
        $this->clear_password = $clear_password;
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
        $this->setSource("user");
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
     * @return User
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
     * @return User
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
     * @return User
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
        return $this->creation_date ? new DateTime($this->creation_date) : null;
    }

    /**
     * @param DateTime $creation_date
     * @return User
     */
    public function setCreationDate(DateTime $creation_date)
    {
        $this->creation_date = $creation_date->format("Y-m-d H:i:sP");
        return $this;
    }
}
