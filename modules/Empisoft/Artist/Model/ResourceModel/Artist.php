<?php

namespace Empisoft\Artist\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Artist extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('artist', 'artist_id');
    }
}
