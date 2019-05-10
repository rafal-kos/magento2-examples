<?php

namespace Empisoft\Artist\Model;

use Empisoft\Artist\Model\ResourceModel\Artist as ResourceArtist;
use Empisoft\Artist\Model\ResourceModel\Artist\CollectionFactory as ArtistCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ArtistRepository
 * @package Empisoft\Artist\Model
 */
class ArtistRepository implements \Empisoft\Artist\Api\ArtistRepositoryInterface
{
    /** @var \Empisoft\Artist\Model\ResourceModel\Artist */
    protected $resource;

    /** @var \Empisoft\Artist\Model\ArtistFactory */
    protected $artistFactory;

    /** @var \Empisoft\Artist\Model\ResourceModel\Artist\CollectionFactory */
    protected $artistCollectionFactory;

    /** @var \Empisoft\Artist\Api\Data\ArtistSearchResultInterface */
    protected $artistSearchResult;

    /** @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface */
    protected $collectionProcessor;

    /**
     * ArtistRepository constructor.
     *
     * @param \Empisoft\Artist\Model\ResourceModel\Artist $resource
     * @param \Empisoft\Artist\Model\ArtistFactory $artistFactory
     * @param \Empisoft\Artist\Model\ResourceModel\Artist\CollectionFactory $artistCollectionFactory
     * @param \Empisoft\Artist\Api\Data\ArtistSearchResultInterface $artistSearchResult
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceArtist $resource,
        \Empisoft\Artist\Model\ArtistFactory $artistFactory,
        ArtistCollectionFactory $artistCollectionFactory,
        \Empisoft\Artist\Api\Data\ArtistSearchResultInterface $artistSearchResult,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->artistFactory = $artistFactory;
        $this->artistCollectionFactory = $artistCollectionFactory;
        $this->artistSearchResult = $artistSearchResult;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save artist
     *
     * @param \Empisoft\Artist\Api\Data\ArtistInterface $artist
     *
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Empisoft\Artist\Api\Data\ArtistInterface $artist)
    {
        try {
            $this->resource->save($artist);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the page: %1', $exception->getMessage()),
                $exception
            );
        }

        return $artist;
    }

    /**
     * @param int $id
     *
     * @return \Empisoft\Artist\Api\Data\ArtistInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $artist = $this->artistFactory->create();
        $artist->load($id);
        if (!$artist->getId()) {
            throw new NoSuchEntityException(__('The artist with the "%1" ID doesn\'t exist.', $id));
        }

        return $artist;
    }

    /**
     * Retrieve artists matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Empisoft\Artist\Model\ResourceModel\Artist\Collection $collection */
        $collection = $this->artistCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var \Empisoft\Artist\Api\Data\ArtistSearchResultInterface $searchResults */
        $searchResults = $this->artistSearchResult->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete artist
     *
     * @param \Empisoft\Artist\Api\Data\ArtistInterface $artist
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Empisoft\Artist\Api\Data\ArtistInterface $artist)
    {
        try {
            $this->resource->delete($artist);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the page: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * Delete artist by ID
     *
     * @param $artistId
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($artistId)
    {
        return $this->delete($this->getById($artistId));
    }
}
