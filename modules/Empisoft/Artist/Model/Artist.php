<?php

namespace Empisoft\Artist\Model;

use Empisoft\Artist\Api\Data\ArtistInterface;
use Magento\Framework\Model\AbstractModel;

class Artist extends AbstractModel implements ArtistInterface
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'artist';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Empisoft\Artist\Model\ResourceModel\Artist::class);
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * Get birthdate
     *
     * @return string|null
     */
    public function getBirthdate()
    {
        return $this->getData(self::BIRTHDATE);
    }

    /**
     * Set firstname
     *
     * @param $firstname
     *
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * Set birthdate
     *
     * @param string $birthdate
     *
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setBirthdate($birthdate)
    {
        return $this->setData(self::BIRTHDATE);
    }
}
