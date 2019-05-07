<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model\Import;

/**
 * Class AdapterList
 *
 * @package Empisoft\InventoryImport\Model\Import
 */
class AdapterList implements \Empisoft\InventoryImport\Api\AdapterListInterface
{
    /** @var array  */
    protected $adapters;

    /**
     * Constructor
     *
     * @param array $adapters
     */
    public function __construct(array $adapters = [])
    {
        $this->adapters = $adapters;
    }

    /**
     * Gets list of import adapters
     *
     * @return \Magento\ImportExport\Model\Import\AbstractSource[]
     */
    public function getAdapters(): array
    {
        return $this->adapters;
    }
}
