<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Console\Command;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for running inventory import
 *
 * @package Empisoft\InventoryImport\Console\Command
 */
class ImportStock extends Command
{
    /** @var \Empisoft\InventoryImport\Model\Importer */
    protected $importer;

    /**
     * ImportStock constructor.
     *
     * @param \Empisoft\InventoryImport\Model\Importer $importer
     */
    public function __construct(
        \Empisoft\InventoryImport\Model\Importer $importer
    ) {
        $this->importer = $importer;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('empisoft:import-stock');
        $this->setDescription('Import stock data from multiple files');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->importer->process();

            return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
        } catch (FileSystemException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        } catch (LocalizedException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        }
    }
}
