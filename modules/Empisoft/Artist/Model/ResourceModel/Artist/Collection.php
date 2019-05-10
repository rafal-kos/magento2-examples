<?php

namespace Empisoft\Artist\Model\ResourceModel\Artist;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'artist_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'artist_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'artist_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Empisoft\Artist\Model\Artist::class, \Empisoft\Artist\Model\ResourceModel\Artist::class);
    }
}

