<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model;

use Magento\Framework\Filesystem\DirectoryList;

/**
 * Class Importer
 *
 * @package Empisoft\InventoryImport\Model
 */
class Importer
{
    /** @var \Empisoft\InventoryImport\Api\ConnectionInterface  */
    protected $connection;

    /** @var \Magento\Framework\Filesystem */
    protected $filesystem;

    /** @var \Magento\Framework\Filesystem\Directory\WriteInterface  */
    protected $tmpDirectory;

    /** @var \Empisoft\InventoryImport\Model\Import\Adapter */
    protected $adapter;

    /** @var \Empisoft\InventoryImport\Api\StockImportInterface */
    protected $stockImport;

    public function __construct(
        \Empisoft\InventoryImport\Api\ConnectionInterface $connection,
        \Magento\Framework\Filesystem $filesystem,
        \Empisoft\InventoryImport\Model\Import\Adapter $adapter,
        \Empisoft\InventoryImport\Api\StockImportInterface $stockImport
    ) {
        $this->filesystem = $filesystem;
        $this->tmpDirectory = $filesystem->getDirectoryWrite(DirectoryList::SYS_TMP);
        $this->connection = $connection;
        $this->adapter = $adapter;
        $this->stockImport = $stockImport;
    }

    /**
     * Fetch files from SFTP and import stock data
     *
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function process(): void
    {
        foreach ($this->connection->list() as $filename) {
            $localFile = 'import_' .
                         uniqid((string)\Magento\Framework\Math\Random::getRandomNumber(), true) .
                         time() . '.' .
                         pathinfo($filename, PATHINFO_EXTENSION);

            if ($this->connection->read($filename, $this->tmpDirectory->getAbsolutePath($localFile))) {
                if (!$this->tmpDirectory->isWritable($localFile)) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('Cannot create a target file for reading.')
                    );
                }
            }

            $source = $this->getSourceAdapter($this->tmpDirectory->getAbsolutePath($localFile));

            foreach ($source as $line) {
                $data = array_values($line);
                $this->stockImport->import($data);
            }
        }
    }

    /**
     * Returns source adapter object.
     *
     * @param string $sourceFile Full path to source file
     *
     * @return \Magento\ImportExport\Model\Import\AbstractSource
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getSourceAdapter($sourceFile): \Magento\ImportExport\Model\Import\AbstractSource
    {
        return $this->adapter->findAdapterFor(
            $sourceFile,
            $this->filesystem->getDirectoryWrite(DirectoryList::SYS_TMP)
        );
    }
}
