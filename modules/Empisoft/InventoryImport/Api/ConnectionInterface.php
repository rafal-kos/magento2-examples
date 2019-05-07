<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Api;

interface ConnectionInterface
{
    /**
     * Get list of all files for import
     *
     * @return array
     */
    public function list(): array;

    /**
     * Read file
     *
     * @param $filename
     * @param $tmpFile
     *
     * @return bool|null
     */
    public function read($filename, $tmpFile): ?bool;
}
