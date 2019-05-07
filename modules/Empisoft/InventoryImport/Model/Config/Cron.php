<?php
declare(strict_types=1);

namespace Empisoft\InventoryImport\Model\Config;

/**
 * Handle custom cron schedule class
 *
 * @package Empisoft\InventoryImport\Model\Config
 */
class Cron extends \Magento\Framework\App\Config\Value
{
    /** @var string Cron string path */
    public const CRON_STRING_PATH = 'crontab/default/jobs/empisoft_import_stock/schedule/cron_expr';

    /** @var string Cron model path */
    public const CRON_MODEL_PATH = 'crontab/default/jobs/empisoft_import_stock/run/model';

    /** @var \Magento\Framework\App\Config\ValueFactory  */
    protected $configValueFactory;

    protected $runModelPath = '';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Config\ValueFactory $configValueFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param string $runModelPath
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        $runModelPath = '',
        array $data = []
    ) {
        $this->runModelPath = $runModelPath;
        $this->configValueFactory = $configValueFactory;

        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Magento\Framework\App\Config\Value
     * @throws \Exception
     */
    public function afterSave(): \Magento\Framework\App\Config\Value
    {
        $time = $this->getData('groups/configurable_cron/fields/time/value');
        $frequency = $this->getData('groups/configurable_cron/fields/frequency/value');

        $cronExprArray = [
            (int)$time[1], //Minute
            (int)$time[0], //Hour
            $frequency == \Magento\Cron\Model\Config\Source\Frequency::CRON_MONTHLY ? '1' : '*', //Day of the Month
            '*', //Month of the Year
            $frequency == \Magento\Cron\Model\Config\Source\Frequency::CRON_WEEKLY ? '1' : '*', //Day of the Week
        ];

        $cronExprString = implode(' ', $cronExprArray);

        try {
            $this->configValueFactory->create()->load(
                self::CRON_STRING_PATH,
                'path'
            )->setValue(
                $cronExprString
            )->setPath(
                self::CRON_STRING_PATH
            )->save();
            $this->configValueFactory->create()->load(
                self::CRON_MODEL_PATH,
                'path'
            )->setValue(
                $this->runModelPath
            )->setPath(
                self::CRON_MODEL_PATH
            )->save();
        } catch (\Exception $e) {
            throw new \RuntimeException(__('We can\'t save the cron expression.'));
        }

        return parent::afterSave();
    }
}
