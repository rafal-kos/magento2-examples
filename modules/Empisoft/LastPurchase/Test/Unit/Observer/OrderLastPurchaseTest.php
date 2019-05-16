<?php

namespace Empisoft\LastPurchase\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Class OrderLastPurchaseTest
 * @package Empisoft\LastPurchase\Test\Unit\Observer
 */
class OrderLastPurchaseTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Magento\Framework\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $objectManagerMock;

    /** @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject */
    private $customerSessionMock;

    /** @var \Magento\Customer\Api\CustomerRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $customerRepositoryMock;

    /** @var \Magento\Framework\Stdlib\DateTime\DateTime|\PHPUnit_Framework_MockObject_MockObject */
    private $dateMock;

    /** @var \Magento\Framework\Event\Observer */
    private $eventObserverMock;

    /** @var \Empisoft\LastPurchase\Observer\OrderLastPurchase */
    private $observer;

    public function setUp()
    {
        $this->objectManagerMock = $this->getMockBuilder(\Magento\Framework\ObjectManagerInterface::class)
                                        ->getMock();
        $this->customerSessionMock = $this->getMockBuilder(
            \Magento\Customer\Model\Session::class
        )->disableOriginalConstructor()
            ->getMock();

        $this->customerRepositoryMock = $this->getMockBuilder(
            \Magento\Customer\Api\CustomerRepositoryInterface::class
        )->disableOriginalConstructor()
            ->getMock();

        $this->dateMock = $this->getMockBuilder(
            \Magento\Framework\Stdlib\DateTime\DateTime::class
        )->disableOriginalConstructor()
            ->getMock();

        $this->eventObserverMock = $this->createMock(
            \Magento\Framework\Event\Observer::class
        );

        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->observer = $objectManager->getObject(
            \Empisoft\LastPurchase\Observer\OrderLastPurchase::class,
            [
                'customerSession' => $this->customerSessionMock,
                'customerRepository' => $this->customerRepositoryMock,
                'date' => $this->dateMock
            ]
        );
    }

    /**
     * @test
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function testExecute()
    {
        $customerMock = $this->getMockBuilder(
            \Magento\Customer\Model\Customer::class
        )->disableOriginalConstructor()
            ->getMock();

        $customerApiMock = $this->createMock(\Magento\Customer\Api\Data\CustomerInterface::class);

        $customerMock
            ->expects($this->once())
            ->method('getDataModel')
            ->willReturn($customerApiMock);


        $this->customerSessionMock
            ->expects($this->once())
            ->method('getCustomer')
            ->willReturn($customerMock);

        $this->observer->execute($this->eventObserverMock);
    }
}
