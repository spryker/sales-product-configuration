<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesProductConfiguration\Business\Collector;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentItemCollectionTransfer;

class SalesProductConfigurationSalesOrderItemCollector implements SalesProductConfigurationSalesOrderItemCollectorInterface
{
    public function collect(
        OrderTransfer $orderTransfer,
        SalesOrderAmendmentItemCollectionTransfer $salesOrderAmendmentItemCollectionTransfer
    ): SalesOrderAmendmentItemCollectionTransfer {
        $itemTransfersToSkipUpdated = [];
        $orderItemTransfersIndexedByIdSalesOrderItem = $this->getItemTransfersIndexedByIdSalesOrderItem($orderTransfer->getItems());

        foreach ($salesOrderAmendmentItemCollectionTransfer->getItemsToSkip() as $itemTransfer) {
            if (!isset($orderItemTransfersIndexedByIdSalesOrderItem[$itemTransfer->getIdSalesOrderItemOrFail()])) {
                continue;
            }

            $orderItemTransfer = $orderItemTransfersIndexedByIdSalesOrderItem[$itemTransfer->getIdSalesOrderItemOrFail()];

            if ($this->isSameConfiguration($itemTransfer, $orderItemTransfer)) {
                $itemTransfersToSkipUpdated[] = $itemTransfer;

                continue;
            }

            $salesOrderAmendmentItemCollectionTransfer->addItemToUpdate($itemTransfer);
        }

        $salesOrderAmendmentItemCollectionTransfer->setItemsToSkip(new ArrayObject($itemTransfersToSkipUpdated));

        return $salesOrderAmendmentItemCollectionTransfer;
    }

    protected function isSameConfiguration(ItemTransfer $itemTransfer, ItemTransfer $orderItemTransfer): bool
    {
        $productConfigurationInstanceTransfer = $itemTransfer->getProductConfigurationInstance();
        $salesOrderItemConfigurationTransfer = $orderItemTransfer->getSalesOrderItemConfiguration();

        if ($productConfigurationInstanceTransfer === null && $salesOrderItemConfigurationTransfer === null) {
            return true;
        }

        $itemConfiguratorKey = $productConfigurationInstanceTransfer?->getConfiguratorKey();
        $orderItemConfiguratorKey = $salesOrderItemConfigurationTransfer?->getConfiguratorKey();
        $itemConfiguration = $productConfigurationInstanceTransfer?->getConfiguration();
        $orderItemConfiguration = $salesOrderItemConfigurationTransfer?->getConfiguration();

        if ($itemConfiguratorKey === $orderItemConfiguratorKey && $itemConfiguration === $orderItemConfiguration) {
            return true;
        }

        return false;
    }

    /**
     * @param \ArrayObject<int,\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return array<int, \Generated\Shared\Transfer\ItemTransfer>
     */
    protected function getItemTransfersIndexedByIdSalesOrderItem(ArrayObject $itemTransfers): array
    {
        $itemTransfersIndexedByIdSalesOrderItem = [];
        foreach ($itemTransfers as $itemTransfer) {
            $itemTransfersIndexedByIdSalesOrderItem[$itemTransfer->getIdSalesOrderItemOrFail()] = $itemTransfer;
        }

        return $itemTransfersIndexedByIdSalesOrderItem;
    }
}
