<?php

namespace Empisoft\LastPurchase\Observer;

/**
 * Class OrderLastPurchase
 * @package Empisoft\LastPurchase\Observer
 */
class OrderLastPurchase implements \Magento\Framework\Event\ObserverInterface
{
    /** @var \Magento\Customer\Model\Session  */
    protected $customerSession;

    /** @var \Magento\Customer\Api\CustomerRepositoryInterface */
    protected $customerRepository;

    /** @var \Magento\Framework\Stdlib\DateTime\DateTime */
    protected $date;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->date = $date;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     *
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $this->customerSession->getCustomer();
        $customer->setLastPurchase($this->date->gmtDate());

        $this->customerRepository->save($customer->getDataModel());
    }
}