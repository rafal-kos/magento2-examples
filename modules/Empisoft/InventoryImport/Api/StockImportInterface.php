<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Api;

interface StockImportInterface
{
    /**
     * Import product stock data
     *
     * @param array $data
     */
    public function import(array $data): void;
}
