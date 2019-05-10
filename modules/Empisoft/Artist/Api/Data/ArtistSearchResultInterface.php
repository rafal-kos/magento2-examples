<?php

namespace Empisoft\Artist\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ArtistSearchResultInterface
 * @package Empisoft\Artist\Api\Data
 */
interface ArtistSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Empisoft\Artist\Api\Data\ArtistInterface[]
     */
    public function getItems();

    /**
     * @param \Empisoft\Artist\Api\Data\ArtistInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
