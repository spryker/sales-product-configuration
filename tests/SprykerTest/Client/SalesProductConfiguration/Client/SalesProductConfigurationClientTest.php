<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\SalesProductConfiguration\Business;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\OrderBuilder;
use Generated\Shared\DataBuilder\SalesOrderItemConfigurationBuilder;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SalesOrderItemConfigurationTransfer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group SalesProductConfiguration
 * @group Business
 * @group SalesProductConfigurationClientTest
 * Add your own group annotations below this line
 */
class SalesProductConfigurationClientTest extends Unit
{
    /**
     * @var string
     */
    protected const TEST_CONFIGURATION = 'TEST_CONFIGURATION';

    /**
     * @var string
     */
    protected const TEST_CONFIGURATOR_KEY = 'TEST_CONFIGURATOR_KEY';

    /**
     * @var string
     */
    protected const TEST_CUSTOMER_REFERENCE = 'TEST_CUSTOMER_REFERENCE';

    /**
     * @var string
     */
    protected const TEST_GROUP_KEY = 'TEST_GROUP_KEY';

    /**
     * @var string
     */
    protected const TEST_DISPLAY_DATA = 'TEST_DISPLAY_DATA';

    /**
     * @var int
     */
    protected const TEST_ID_SALES_ORDER_ITEM = 1;

    /**
     * @var string
     */
    protected const TEST_ORDER_REFERENCE = 'TEST_ORDER_REFERENCE';

    /**
     * @var \Spryker\Client\SalesProductConfiguration\SalesProductConfigurationClientInterface
     */
    protected $salesProductConfigurationClient;

    /**
     * @var \Spryker\Client\SalesProductConfiguration\SalesProductConfigurationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $salesProductConfigurationFactoryMock;

    /**
     * @var \SprykerTest\Client\SalesProductConfiguration\SalesProductConfigurationClientTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->salesProductConfigurationClient = $this->tester->getClient();
    }

    /**
     * @return void
     */
    public function testExpandItemsWithProductConfigurationFromPreviousOrderCheckExpanderSuccess(): void
    {
        //Arrange
        $salesOrderItemConfiguration = (new SalesOrderItemConfigurationBuilder())->build()->fromArray([
            SalesOrderItemConfigurationTransfer::DISPLAY_DATA => static::TEST_DISPLAY_DATA,
            SalesOrderItemConfigurationTransfer::CONFIGURATION => static::TEST_CONFIGURATION,
            SalesOrderItemConfigurationTransfer::CONFIGURATOR_KEY => static::TEST_CONFIGURATOR_KEY,
        ]);

        $itemTransfer = (new ItemBuilder([
            ItemTransfer::ID_SALES_ORDER_ITEM => static::TEST_ID_SALES_ORDER_ITEM,
            ItemTransfer::GROUP_KEY => static::TEST_GROUP_KEY,
            ItemTransfer::SALES_ORDER_ITEM_CONFIGURATION => $salesOrderItemConfiguration,
        ]))->build();

        $orderTransfer = (new OrderBuilder())->build()->fromArray([
            OrderTransfer::ORDER_REFERENCE => static::TEST_ORDER_REFERENCE,
            OrderTransfer::CUSTOMER_REFERENCE => static::TEST_CUSTOMER_REFERENCE,
        ]);

        $salesOrderItems = new ArrayObject();
        $salesOrderItems->append($itemTransfer);
        $orderTransfer->setItems($salesOrderItems);

        //Act
        /** @var array<\Generated\Shared\Transfer\ItemTransfer> $itemTransferExpandedCollection */
        $itemTransferExpandedCollection = $this->tester->getClient()->expandItemsWithProductConfiguration([$itemTransfer], $orderTransfer);

        $productConfigurationInstance = array_shift($itemTransferExpandedCollection)
            ->getProductConfigurationInstance();

        //Assert
        $this->assertSame(
            static::TEST_DISPLAY_DATA,
            $productConfigurationInstance->getDisplayData(),
            'Expects product configuration `displayData` property expanded with order item value.',
        );

        $this->assertSame(
            static::TEST_CONFIGURATION,
            $productConfigurationInstance->getConfiguration(),
            'Expects product configuration `configuration` property expanded with order item value.',
        );

        $this->assertSame(
            static::TEST_CONFIGURATOR_KEY,
            $productConfigurationInstance->getConfiguratorKey(),
            'Expects product configuration `configuratorKey` property expanded with order item value.',
        );

        $this->assertTrue(
            $productConfigurationInstance->getIsComplete(),
            'Expects product configuration `isComplete` property expanded with order item value.',
        );
    }
}
