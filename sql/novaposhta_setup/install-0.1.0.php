<?php
/**
 * Copyright [2017] Illia Voinov <ilya.voinov@yahoo.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
/** @var Mage_Core_Model_Resource_Setup $this */
$this->startSetup();
$connection = $this->getConnection();
$areasTable = $this->getTable('novaposhta/entity_area');
$citiesTable = $this->getTable('novaposhta/entity_city');
$warehousesTable = $this->getTable('novaposhta/entity_warehouse');
if (!$connection->isTableExists($areasTable)) {
    $table = $connection->newTable($areasTable)->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array('unsigned' => true, 'nullable' => false, 'primary' => true, 'identity' => true), 'ID')
        ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null,
            array('unsigned' => true, 'nullable' => true, 'default' => null), 'Description')
        ->addColumn('reference', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('unsigned' => true, 'nullable' => false),
            'Reference')
        ->addColumn('areas_center', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('unsigned' => true, 'nullable' => false),
            'Areas center')->addColumn('sync_status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array('unsigned' => true, 'nullable' => true, 'default' => 0), 'Flag is cities for this areas synced')
        ->addColumn('synced_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
            array('unsigned' => true, 'nullable' => false), 'Last synced date');

    $connection->createTable($table);
}
if (!$connection->isTableExists($citiesTable)) {
    $table = $connection->newTable($citiesTable)->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array('unsigned' => true, 'nullable' => false, 'primary' => true, 'identity' => true), 'ID')
        ->addColumn('reference', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('unsigned' => true, 'nullable' => false),
            'Reference')->addColumn('settlement_type', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array('unsigned' => true, 'nullable' => true, 'default' => null), 'Settlement Type')
        ->addColumn('latitude', Varien_Db_Ddl_Table::TYPE_DECIMAL, null,
            array('unsigned' => true, 'nullable' => true, 'default' => null, 'precision' => 12, 'scale' => 9),
            'Latitude')->addColumn('longitude', Varien_Db_Ddl_Table::TYPE_DECIMAL, null,
            array('unsigned' => true, 'nullable' => true, 'default' => null, 'precision' => 12, 'scale' => 9),
            'Longitude')->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null,
            array('unsigned' => true, 'nullable' => false, 'default' => ''), 'Description')
        ->addColumn('area_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('unsigned' => true, 'nullable' => false,),
            'City area')->addForeignKey($connection->getForeignKeyName($citiesTable, 'area_id', $areasTable, 'id'),
            'area_id', $areasTable, 'id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
    $connection->createTable($table);
}
if (!$connection->isTableExists($warehousesTable)) {
    $table = $connection->newTable($warehousesTable)->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array('unsigned' => true, 'nullable' => false, 'primary' => true, 'identity' => true), 'ID')
        ->addColumn('reference', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('unsigned' => true, 'nullable' => false),
            'Reference')
        ->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('unsigned' => true, 'nullable' => false),
            'Warehouse code')
        ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('unsigned' => true, 'nullable' => false),
            'Description')->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array('unsigned' => true, 'nullable' => true, 'default' => ''), 'Phone')
        ->addColumn('type', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array('unsigned' => true, 'nullable' => true, 'default' => ''), 'Type')
        ->addColumn('city_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('unsigned' => true, 'nullable' => false),
            'City id')->addColumn('city_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array('unsigned' => true, 'nullable' => true, 'default' => ''), 'City name')
        ->addColumn('latitude', Varien_Db_Ddl_Table::TYPE_DECIMAL, null,
            array('unsigned' => true, 'nullable' => true, 'default' => null, 'precision' => 12, 'scale' => 9),
            'Latitude')->addColumn('longitude', Varien_Db_Ddl_Table::TYPE_DECIMAL, null,
            array('unsigned' => true, 'nullable' => true, 'default' => null, 'precision' => 12, 'scale' => 9),
            'Longitude')->addForeignKey($connection->getForeignKeyName($warehousesTable, 'city_id', $citiesTable, 'id'),
            'city_id', $citiesTable, 'id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
    $connection->createTable($table);
}
$this->endSetup();