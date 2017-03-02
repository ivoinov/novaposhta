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

/**
 * Class IV_NovaPoshta_Model_Resource_Entity_Warehouse_Collection
 */
class IV_NovaPoshta_Model_Resource_Entity_Warehouse_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @var string
     */
    protected $_eventObject = 'warehouse_collection';
    /**
     * @var string
     */
    protected $_eventPrefix = 'novaposhta_warehouse_collection';

    /**
     * {@inheritdoc}w
     */
    protected function _construct()
    {
        $this->_init('novaposhta/entity_warehouse');
    }
}