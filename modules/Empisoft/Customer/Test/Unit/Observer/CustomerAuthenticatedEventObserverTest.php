<?php

namespace Empisoft\Customer\Test\Unit\Observer;

/**
 * Class CustomerAuthenticatedEventObserverTest
 * @package Empisoft\Customer\Test\Unit\Observer
 */
class CustomerAuthenticatedEventObserverTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Empisoft\Customer\Observer\CustomerAuthenticatedEventObserver|\PHPUnit_Framework_MockObject_MockObject */
    private $observer;

    /** @var \Magento\Framework\Event\Observer|\PHPUnit_Framework_MockObject_MockObject */
    private $eventObserverMock;

    /** @var \Magento\Customer\Model\Customer|\PHPUnit_Framework_MockObject_MockObject */
    private $customerMock;

    public function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->eventObserverMock = $this->getMockBuilder(
            \Magento\Framework\Event\Observer::class
        )->disableOriginalConstructor()
            ->setMethods(['getModel'])
            ->getMock();

        $this->customerMock = $this->getMockBuilder(
            \Magento\Customer\Model\Customer::class
        )->disableOriginalConstructor()
            ->setMethods(['getActivated'])
            ->getMock();

        $this->observer = $objectManager->getObject(
            \Empisoft\Customer\Observer\CustomerAuthenticatedEventObserver::class
        );
    }

    /**
     * @doesNotPerformAssertions
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testSuccessForActivatedCustomer()
    {
        $this->customerMock->expects($this->any())
            ->method('getActivated')
            ->willReturn(1);

        $this->eventObserverMock->expects($this->any())
            ->method('getModel')
            ->willReturn($this->customerMock);

        $this->observer->execute($this->eventObserverMock);
    }

    /**
     * @test
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testFailureForDisabledCustomer()
    {
        $this->expectException(\Magento\Framework\Exception\LocalizedException::class);

        $this->customerMock->expects($this->any())
            ->method('getActivated')
            ->willReturn(0);

        $this->eventObserverMock->expects($this->any())
                                ->method('getModel')
                                ->willReturn($this->customerMock);

        $this->observer->execute($this->eventObserverMock);
    }
}
