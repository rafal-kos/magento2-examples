<?php

namespace Empisoft\InventoryImportJson\Model\Import\Source;

class Json extends \Magento\ImportExport\Model\Import\AbstractSource implements
    \Empisoft\InventoryImport\Api\ImportSourceInterface
{

    /**
     * Render next row
     *
     * Return array or false on error
     *
     * @return array|false
     */
    protected function _getNextRow()
    {
        // TODO: Implement _getNextRow() method.
    }

    /**
     * Check if source import supports specific extension
     *
     * @param $extension
     *
     * @return bool
     */
    public function supports($extension): bool
    {
        // TODO: Implement supports() method.
    }
}
