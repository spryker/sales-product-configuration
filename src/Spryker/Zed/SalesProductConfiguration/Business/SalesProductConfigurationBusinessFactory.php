<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesProductConfiguration\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\SalesProductConfiguration\Business\Collector\SalesProductConfigurationSalesOrderItemCollector;
use Spryker\Zed\SalesProductConfiguration\Business\Collector\SalesProductConfigurationSalesOrderItemCollectorInterface;
use Spryker\Zed\SalesProductConfiguration\Business\Deleter\SalesOrderItemConfigurationDeleter;
use Spryker\Zed\SalesProductConfiguration\Business\Deleter\SalesOrderItemConfigurationDeleterInterface;
use Spryker\Zed\SalesProductConfiguration\Business\Expander\OrderItemExpander;
use Spryker\Zed\SalesProductConfiguration\Business\Expander\OrderItemExpanderInterface;
use Spryker\Zed\SalesProductConfiguration\Business\Hydrator\CartReorderItemHydrator;
use Spryker\Zed\SalesProductConfiguration\Business\Hydrator\CartReorderItemHydratorInterface;
use Spryker\Zed\SalesProductConfiguration\Business\Writer\SalesOrderItemConfigurationWriter;
use Spryker\Zed\SalesProductConfiguration\Business\Writer\SalesOrderItemConfigurationWriterInterface;

/**
 * @method \Spryker\Zed\SalesProductConfiguration\Persistence\SalesProductConfigurationEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\SalesProductConfiguration\Persistence\SalesProductConfigurationRepositoryInterface getRepository()
 * @method \Spryker\Zed\SalesProductConfiguration\SalesProductConfigurationConfig getConfig()
 */
class SalesProductConfigurationBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\SalesProductConfiguration\Business\Writer\SalesOrderItemConfigurationWriterInterface
     */
    public function createSalesOrderItemConfigurationWriter(): SalesOrderItemConfigurationWriterInterface
    {
        return new SalesOrderItemConfigurationWriter(
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Spryker\Zed\SalesProductConfiguration\Business\Expander\OrderItemExpanderInterface
     */
    public function createOrderItemExpander(): OrderItemExpanderInterface
    {
        return new OrderItemExpander(
            $this->getRepository(),
        );
    }

    /**
     * @return \Spryker\Zed\SalesProductConfiguration\Business\Hydrator\CartReorderItemHydratorInterface
     */
    public function createCartReorderItemHydrator(): CartReorderItemHydratorInterface
    {
        return new CartReorderItemHydrator();
    }

    /**
     * @return \Spryker\Zed\SalesProductConfiguration\Business\Deleter\SalesOrderItemConfigurationDeleterInterface
     */
    public function createSalesOrderItemConfigurationDeleter(): SalesOrderItemConfigurationDeleterInterface
    {
        return new SalesOrderItemConfigurationDeleter($this->getEntityManager());
    }

    /**
     * @return \Spryker\Zed\SalesProductConfiguration\Business\Collector\SalesProductConfigurationSalesOrderItemCollectorInterface
     */
    public function createSalesProductConfigurationSalesOrderItemCollector(): SalesProductConfigurationSalesOrderItemCollectorInterface
    {
        return new SalesProductConfigurationSalesOrderItemCollector();
    }
}
