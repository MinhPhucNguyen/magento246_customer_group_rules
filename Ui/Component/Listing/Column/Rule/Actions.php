<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Ui\Component\Listing\Column\Rule;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    protected $urlBuilder;

    private const  URL_PATH_EDIT = 'customergrouprule/rule/edit';
    private const URL_PATH_DELETE = 'customergrouprule/rule/delete';

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        private Escaper    $escaper,
        array              $components = [],
        array              $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['rule_id'])) {
                    $name = $this->getData('name');

                    $item[$name]['edit'] = [
                        'href' => $this->getEditUrl($item),
                        'label' => __('Edit'),
                    ];
                    $title = $this->escaper->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->getDeleteUrl($item),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you wan\'t to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }
        return $dataSource;
    }

    /**
     * @param array $item
     * @return string
     */
    private function getEditUrl(array $item)
    {
        return $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['rule_id' => $item['rule_id']]);
    }

    /**
     * @param array $item
     * @return string
     */
    private function getDeleteUrl(array $item)
    {
        return $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['rule_id' => $item['rule_id']]);
    }
}
