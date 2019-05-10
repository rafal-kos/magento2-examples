<?php

namespace Empisoft\Artist\Controller\Adminhtml\Artist;

class Grid extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /** @var \Magento\Framework\Registry */
    protected $coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        $this->coreRegistry = $registry;
    }

    /**
     * Grid Action
     * Display list of products related to current artist
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $artist = $this->_objectManager->create(\Empisoft\Artist\Model\Artist::class);
        $artist->load($id);

        if (!$artist) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('artist/*/', ['_current' => true, 'id' => null]);
        }

        $this->coreRegistry->register('artist', $artist);

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                \Empisoft\Artist\Block\Adminhtml\Artist\Tab\Product::class,
                'category.product.grid'
            )->toHtml()
        );
    }
}
