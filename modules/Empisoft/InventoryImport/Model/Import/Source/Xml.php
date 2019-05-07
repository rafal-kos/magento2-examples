<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model\Import\Source;

/**
 * Class Xml
 *
 * @package Empisoft\InventoryImport\Model\Import\Source
 */
class Xml extends \Magento\ImportExport\Model\Import\AbstractSource implements
    \Empisoft\InventoryImport\Api\ImportSourceInterface
{
    public const ITEM_NODE = 'item';

    protected $extensions = ['xml'];

    /** @var \XMLReader  */
    protected $reader;

    public function __construct(
        $file,
        \Magento\Framework\Filesystem\Directory\Read $directory
    ) {
        $this->reader = new \XMLReader();
        if (!$this->reader->open($file)) {
            throw new \LogicException("Unable to open file: '{$file}'");
        }

        while ($this->reader->read() && $this->reader->name !== self::ITEM_NODE) {
            // find first item node
        }

        parent::__construct(['id', 'sku', 'qty', 'source']);
    }

    /**
     * Close file handle
     *
     * @return void
     */
    public function destruct(): void
    {
        $this->reader->close();
    }

    /**
     * Render next row
     *
     * Return array or false on error
     *
     * @return array|false
     */
    protected function _getNextRow()
    {
        $data = simplexml_load_string($this->reader->readOuterXML());
        if (!$data) {
            return [];
        }

        $this->reader->next(self::ITEM_NODE);

        return [
            (string)$data->gtin,
            (string)$data->id,
            (string)$data->quantity,
            'default'
        ];
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
