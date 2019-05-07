<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Api;

/**
 * List if import adapters
 * @api
 */
interface AdapterListInterface
{
    /**
     * Gets list of import adapters
     *
     * @return \Magento\ImportExport\Model\Import\AbstractSource[]
     */
    public function getAdapters(): array;
}
