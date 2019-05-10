<?php

namespace Empisoft\Artist\Model\Artist;

use Empisoft\Artist\Model\ResourceModel\Artist\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Empisoft\Artist\Model\ResourceModel\Artist\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $artistCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $artistCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $artistCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $page \Magento\Cms\Model\Page */
        foreach ($items as $artist) {
            $this->convertValues($artist);
            $this->loadedData[$artist->getId()] = $artist->getData();
        }

        $data = $this->dataPersistor->get('artist');
        if (!empty($data)) {
            $artist = $this->collection->getNewEmptyItem();
            $artist->setData($data);
            $this->loadedData[$artist->getId()] = $artist->getData();
            $this->dataPersistor->clear('artist');
        }

        return $this->loadedData;
    }

    /**
     * Converts data to acceptable for rendering format
     *
     * @param \Empisoft\Artist\Model\Artist $artist
     *
     * @return \Empisoft\Artist\Model\Artist $artist
     */
    private function convertValues($artist)
    {
        return $artist;
    }
}
