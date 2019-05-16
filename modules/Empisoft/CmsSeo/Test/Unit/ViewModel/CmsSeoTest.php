<?php

namespace Empisoft\CmsSeo\Test\Unit\ViewModel;

use Empisoft\CmsSeo\ViewModel\CmsSeo;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class CmsSeoTest
 * @package Empisoft\CmsSeo\Test\Unit\ViewModel
 */
class CmsSeoTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Empisoft\CmsSeo\ViewModel\CmsSeo|\PHPUnit_Framework_MockObject_MockObject */
    private $viewModel;

    /** @var \Magento\Cms\Helper\Page|\PHPUnit_Framework_MockObject_MockObject */
    private $cmsHelperMock;

    public function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $pageMock = $this->getMockBuilder(\Magento\Cms\Model\Page::class)
            ->disableOriginalConstructor()
            ->getMock();
        $storeManagerMock = $this->getMockBuilder(\Magento\Store\Model\StoreManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cmsHelperMock = $this->getMockBuilder(\Magento\Cms\Helper\Page::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewModel = $objectManager->getObject(
            CmsSeo::class,
            [
                'page' => $pageMock,
                'storeManager' => $storeManagerMock,
                'scopeConfig' => $this->getScopeConfigMock(),
                'cmsHelper' => $this->cmsHelperMock
            ]
        );
    }

    public function testGetPageUrl()
    {
        $this->cmsHelperMock->expects($this->once())
            ->method('getPageUrl')
            ->willReturn('cms-url');

        $this->assertInternalType('string', $this->viewModel->getPageUrl());
    }

    public function testGetStoreLanguage()
    {
        $this->assertEquals('en-us', $this->viewModel->getStoreLanguage());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getScopeConfigMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $scopeConfigMock = $this->getMockForAbstractClass(ScopeConfigInterface::class);
        $scopeConfigMock->expects($this->any())
                        ->method('getValue')
                        ->willReturnMap([
                            [CmsSeo::LANG_PATH, ScopeInterface::SCOPE_STORE, null, 'en_US']
                        ]);

        return $scopeConfigMock;
    }
}
