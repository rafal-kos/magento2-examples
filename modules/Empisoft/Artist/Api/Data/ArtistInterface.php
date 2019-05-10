<?php

namespace Empisoft\Artist\Api\Data;

interface ArtistInterface
{
    const ARTIST_ID = 'artist_id';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const BIRTHDATE = 'birthdate';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname();

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname();

    /**
     * Get birthdate
     *
     * @return string|null
     */
    public function getBirthdate();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setId($id);

    /**
     * Set firstname
     *
     * @param $firstname
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setFirstname($firstname);

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setLastname($lastname);

    /**
     * Set birthdate
     *
     * @param string $birthdate
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function setBirthdate($birthdate);
}
