<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesProductConfiguration\Persistence;

use Generated\Shared\Transfer\SalesOrderItemConfigurationTransfer;

interface SalesProductConfigurationEntityManagerInterface
{
    public function saveSalesOrderItemConfiguration(SalesOrderItemConfigurationTransfer $salesOrderItemConfigurationTransfer): void;

    public function saveSalesOrderItemConfigurationByFkSalesOrderItem(
        SalesOrderItemConfigurationTransfer $salesOrderItemConfigurationTransfer
    ): SalesOrderItemConfigurationTransfer;

    /**
     * @param array<int> $salesOrderItemIds
     *
     * @return void
     */
    public function deleteSalesOrderItemConfigurationsBySalesOrderItemIds(array $salesOrderItemIds): void;
}
