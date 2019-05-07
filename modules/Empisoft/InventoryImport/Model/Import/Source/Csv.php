<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model\Import\Source;

/**
 * Class Csv
 *
 * @package Empisoft\InventoryImport\Model\Import\Source
 */
class Csv extends \Magento\ImportExport\Model\Import\Source\Csv implements
    \Empisoft\InventoryImport\Api\ImportSourceInterface
{
    protected $extensions = ['csv', 'txt'];

    /**
     * Rewind the \Iterator to the first element (\Iterator interface)
     *
     * @return void
     */
    public function rewind()
    {
        $this->_file->seek(0);
        \Magento\ImportExport\Model\Import\AbstractSource::rewind();
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
        return in_array($extension, $this->extensions, true);
    }
}
