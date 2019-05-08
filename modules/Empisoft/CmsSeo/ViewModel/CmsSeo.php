<?php

namespace Empisoft\CmsSeo\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class CmsSeo
 * @package Empisoft\CmsSeo\ViewModel
 */
class CmsSeo implements ArgumentInterface
{
    const LANG_PATH = 'general/locale/code';

    /** @var \Magento\Cms\Model\Page */
    protected $page;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    /** @var \Magento\Cms\Helper\Page */
    protected $cmsHelper;

    public function __construct(
        \Magento\Cms\Model\Page $page,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Cms\Helper\Page $cmsHelper
    ) {
        $this->page = $page;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->cmsHelper = $cmsHelper;
    }

    /**
     * @return string
     */
    public function getPageUrl()
    {
        return $this->cmsHelper->getPageUrl($this->page->getIdentifier());
    }

    /**
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isPageInStores()
    {
        $stores = $this->storeManager->getStores();
        $identifier = $this->page->getIdentifier();

        foreach ($stores as $store) {
            // ignore current store
            if ($store->getId() === $this->storeManager->getStore()->getId()) {
                continue;
            }
            if ($this->page->checkIdentifier($identifier, $store->getId())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return store locale (replace _ with -)
     * For example : en_US => en-us
     *
     * @return mixed
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreLanguage()
    {
        $locale = $this->scopeConfig->getValue(
            self::LANG_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()
        );

        return str_replace('_', '-', strtolower($locale));
    }
}