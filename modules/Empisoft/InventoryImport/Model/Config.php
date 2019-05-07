<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model;

/**
 * Class Config
 *
 * @package Empisoft\InventoryImport\Model
 */
class Config
{
    /** @var \Magento\Framework\App\Config\ScopeConfigInterface  */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getHostname(): string
    {
        return $this->scopeConfig->getValue(
            'cataloginventory/sftp/hostname',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getUsername(): string
    {
        return $this->scopeConfig->getValue(
            'cataloginventory/sftp/username',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getPassword(): string
    {
        return $this->scopeConfig->getValue(
            'cataloginventory/sftp/password',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getPath(): string
    {
        return $this->scopeConfig->getValue(
            'cataloginventory/sftp/path',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
