<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model;

/**
 * Basic stock data import class
 *
 * @package Empisoft\InventoryImport\Model
 */
class StockImportBasic implements \Empisoft\InventoryImport\Api\StockImportInterface
{
    /** @var \Magento\InventoryApi\Api\SourceItemsSaveInterface  */
    private $sourceItemsSaveInterface;

    /** @var \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory   */
    private $sourceItemFactory;

    public function __construct(
        \Magento\InventoryApi\Api\SourceItemsSaveInterface $sourceItemsSaveInterface,
        \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory $sourceItemInterfaceFactory
    ) {
        $this->sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->sourceItemFactory = $sourceItemInterfaceFactory;
    }

    public function import(array $data): void
    {
        $sourceItem = $this->sourceItemFactory->create();
        $sourceItem->setSourceCode('default');
        $sourceItem->setSku($data[1]);
        $sourceItem->setQuantity((float)$data[2]);
        $sourceItem->setStatus((int)($data[2] > 0));

        $this->sourceItemsSaveInterface->execute([$sourceItem]);
    }
}
