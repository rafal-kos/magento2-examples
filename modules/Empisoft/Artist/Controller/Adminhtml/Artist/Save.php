<?php

namespace Empisoft\Artist\Controller\Adminhtml\Artist;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Empisoft\Artist\Controller\Adminhtml\Artist
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('id');

            if (empty($data['id'])) {
                $data['id'] = null;
            }

            /** @var \Empisoft\Artist\Model\Artist $model */
            $model = $this->_objectManager->create(\Empisoft\Artist\Model\Artist::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This artist no longer exists.'));

                return $resultRedirect->setPath('*/*/');
            }

            $data         = $this->filterData($data);
            $model->setData($data);

            try {
                $model->save();

                $this->messageManager->addSuccessMessage(__('You saved the artist.'));
                $this->dataPersistor->clear('artist');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the artist.' . $e->getMessage()));
            }

            $this->dataPersistor->set('artist', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param array $data
     *
     * @return array
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    private function filterData(array $data)
    {
        return $data;
    }
}
