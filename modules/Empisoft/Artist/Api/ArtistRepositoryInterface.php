<?php

namespace Empisoft\Artist\Api;

interface ArtistRepositoryInterface
{
    /**
     * Save artist
     *
     * @param \Empisoft\Artist\Api\Data\ArtistInterface $artist
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function save(\Empisoft\Artist\Api\Data\ArtistInterface $artist);

    /**
     * Retrieve artist
     *
     * @param int $id
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     */
    public function getById($id);

    /**
     * Retrieve artists matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete artist
     *
     * @param \Empisoft\Artist\Api\Data\ArtistInterface $artist
     * @return mixed
     */
    public function delete(\Empisoft\Artist\Api\Data\ArtistInterface $artist);

    /**
     * Delete artist by ID
     *
     * @param $artistId
     * @return mixed
     */
    public function deleteById($artistId);
}
