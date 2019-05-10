<?php

namespace Empisoft\Customer\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class CustomerAuthenticatedEventObserver
 */
class CustomerAuthenticatedEventObserver implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $observer->getEvent()->getModel();

        if ((int)$customer->getActivated() !== 1) {
            throw new LocalizedException(__('Customer is not activated'));
        }
    }
}
