<?php

namespace Empisoft\Artist\Block\Adminhtml\Artist\Edit;

use Empisoft\Artist\Model\ArtistFactory;
use Empisoft\Artist\Model\ResourceModel\Artist as ResourceArtist;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /** @var \Magento\Backend\Block\Widget\Context */
    protected $context;

    /** @var \Empisoft\Artist\Model\ResourceModel\Artist */
    protected $resource;

    /** @var \Empisoft\Artist\Model\ArtistFactory */
    protected $artistFactory;

    /**
     * GenericButton constructor.
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Empisoft\Artist\Model\ResourceModel\Artist $resource
     * @param \Empisoft\Artist\Model\ArtistFactory $artistFactory
     */
    public function __construct(
        Context $context,
        ResourceArtist $resource,
        ArtistFactory $artistFactory
    ) {
        $this->context = $context;
        $this->resource = $resource;
        $this->artistFactory = $artistFactory;
    }

    /**
     * Return Artist ID
     *
     * @return int|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getArtistId()
    {
        try {
            $artist = $this->artistFactory->create();
            $this->resource->load($artist, $this->context->getRequest()->getParam('id'));
            return $artist->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
