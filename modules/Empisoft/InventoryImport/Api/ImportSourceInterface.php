<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Api;

interface ImportSourceInterface
{
    /**
     * Check if source import supports specific extension
     *
     * @param $extension
     *
     * @return bool
     */
    public function supports($extension): bool;
}
