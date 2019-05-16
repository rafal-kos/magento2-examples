<?php

namespace Empisoft\Artist\Test\Unit\Model;

use Empisoft\Artist\Model\ArtistRepository;

class ArtistRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /** @var ArtistRepository|\PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    /** @var \Empisoft\Artist\Model\ResourceModel\Artist|\PHPUnit_Framework_MockObject_MockObject */
    private $artistResourceMock;

    /** @var \Empisoft\Artist\Model\Artist|\PHPUnit_Framework_MockObject_MockObject */
    private $artistMock;

    /** @var \Empisoft\Artist\Model\ResourceModel\Artist\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $artistCollectionMock;

    /** @var \Empisoft\Artist\Api\Data\ArtistSearchResultInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $artistSearchResultMock;

    /** @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $collectionProcessorMock;

    public function setUp()
    {
        $this->artistResourceMock = $this->getMockBuilder(
            \Empisoft\Artist\Model\ResourceModel\Artist::class
        )->disableOriginalConstructor()
            ->getMock();

        $this->artistMock = $this->getMockBuilder(
            \Empisoft\Artist\Model\Artist::class
        )->disableOriginalConstructor()
            ->getMock();

        $artistFactory = $this->getMockBuilder(\Empisoft\Artist\Model\ArtistFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->artistCollectionMock = $this->getMockBuilder(
            \Empisoft\Artist\Model\ResourceModel\Artist\CollectionFactory::class
        )->disableOriginalConstructor()
            ->getMock();

        $this->artistSearchResultMock = $this->getMockBuilder(
            \Empisoft\Artist\Api\Data\ArtistSearchResultInterface::class
        )->disableOriginalConstructor()
            ->getMock();

        $this->collectionProcessorMock = $this->getMockBuilder(
            \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface::class
        )->getMockForAbstractClass();

        $artistFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->artistMock);

        $this->repository = new ArtistRepository(
            $this->artistResourceMock,
            $artistFactory,
            $this->artistCollectionMock,
            $this->artistSearchResultMock,
            $this->collectionProcessorMock
        );
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->artistResourceMock->expects($this->once())
            ->method('save')
            ->with($this->artistMock)
            ->willReturnSelf();

        $this->assertEquals($this->artistMock, $this->repository->save($this->artistMock));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     */
    public function testSaveException()
    {
        $this->artistResourceMock->expects($this->once())
            ->method('save')
            ->with($this->artistMock)
            ->willThrowException(new \Exception());

        $this->repository->save($this->artistMock);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function testDeleteException()
    {
        $this->artistResourceMock->expects($this->once())
            ->method('delete')
            ->with($this->artistMock)
            ->willThrowException(new \Exception());
        $this->repository->delete($this->artistMock);
    }

    /**
     * @test
     */
    public function testDeleteById()
    {
        $pageId = '111';

        $this->artistMock->expects($this->once())
            ->method('getId')
            ->willReturn(true);
        $this->artistMock->expects($this->once())
            ->method('load')
            ->with($pageId)
            ->willReturnSelf();
        $this->artistResourceMock->expects($this->once())
            ->method('delete')
            ->with($this->page)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($pageId));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testGetByIdException()
    {
        $artistId = '111';

        $this->artistMock->expects($this->once())
            ->method('getId')
            ->willReturn(false);
        $this->artistMock->expects($this->once())
            ->method('load')
            ->with($artistId)
            ->willReturnSelf();

        $this->repository->getById($artistId);
    }
}
