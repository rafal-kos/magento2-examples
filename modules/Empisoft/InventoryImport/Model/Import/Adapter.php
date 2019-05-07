<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model\Import;

use Magento\Framework\Filesystem\Directory\WriteInterface;

/**
 * Factory class for source adapters
 *
 * @package Empisoft\InventoryImport\Model\Import
 */
class Adapter
{
    /** @var \Empisoft\InventoryImport\Api\AdapterListInterface */
    protected $adapterList;

    public function __construct(
        \Empisoft\InventoryImport\Api\AdapterListInterface $adapterList
    ) {
        $this->adapterList = $adapterList;
    }

    /**
     * Adapter factory. Checks for availability, loads and create instance of import adapter object.
     *
     * @param string $type   Adapter type ('csv', 'xml' etc.)
     * @param WriteInterface $directory
     * @param string $source
     * @param mixed $options OPTIONAL Adapter constructor options
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function factory(
        $type,
        $directory,
        $source,
        $options = null
    ): \Magento\ImportExport\Model\Import\AbstractSource {
        if (!is_string($type) || !$type) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The adapter type must be a non-empty string.')
            );
        }

        foreach ($this->adapterList->getAdapters() as $adapter) {
            $reader = $adapter->create([
                'file' => $source,
                'directory' => $directory,
                $options
            ]);

            if ($reader->supports(strtolower($type))) {
                return $reader;
            }
        }

        throw new \Magento\Framework\Exception\LocalizedException(
            __('\'%1\' file extension is not supported', $type)
        );
    }

    /**
     * Create adapter instance for specified source file.
     *
     * @param string $source Source file path.
     * @param WriteInterface $directory
     * @param mixed $options OPTIONAL Adapter constructor options
     *
     * @return \Magento\ImportExport\Model\Import\AbstractSource
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function findAdapterFor(
        $source,
        $directory,
        $options = null
    ): \Magento\ImportExport\Model\Import\AbstractSource {
        return $this->factory($this->getExtension($source), $directory, $source, $options);
    }

    /**
     * Get souce file extension
     *
     * @param $source
     *
     * @return string
     */
    protected function getExtension($source): string
    {
        return strtolower(pathinfo($source, PATHINFO_EXTENSION));
    }
}
