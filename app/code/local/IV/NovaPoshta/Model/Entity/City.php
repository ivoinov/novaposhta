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
 * Class IV_NovaPoshta_Model_Entity_City
 * @method IV_NovaPoshta_Model_Entity_City setReference(string $reference)
 * @method IV_NovaPoshta_Model_Entity_City setSettlementType(string $settlementType)
 * @method IV_NovaPoshta_Model_Entity_City setLatitude(float $latitude)
 * @method IV_NovaPoshta_Model_Entity_City setLongitude(float $longitude)
 * @method IV_NovaPoshta_Model_Entity_City setDescription(string $description)
 * @method IV_NovaPoshta_Model_Entity_City setAreaId(integer $areaId)
 * @method IV_NovaPoshta_Model_Resource_Entity_City getResource()
 * @method string getReference()
 * @method string getSettlementType()
 * @method float getLatitude()
 * @method float getLongitude()
 * @method string getDescription()
 * @method string getRegionName()
 * @method string getRegionReference()
 * @method string getRegionCenterReference()
 * @method string getRegionSyncStatus()
 * @method string getRegionSyncedAt()
 * @method integer getAreaId()
 * @method setApiData(array $apiData)
 */
class IV_NovaPoshta_Model_Entity_City extends IV_NovaPoshta_Model_Entity_Abstract
{
    /**
     * @var array
     */
    protected $_attributeMapping
        = array(
            'Ref'            => 'reference',
            'SettlementType' => 'settlement_type',
            'Latitude'       => 'latitude',
            'Longitude'      => 'longitude',
            'Description'    => 'description',
        );
    /**
     * @var string
     */
    protected $_eventObject = 'city';
    /**
     * @var string
     */
    protected $_eventPrefix = 'novaposhta_city';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('novaposhta/entity_city');
        parent::_construct();
    }

    /**
     * Load city entity by reference.
     *
     * @param string $reference
     *
     * @return IV_NovaPoshta_Model_Entity_City $this
     */
    public function loadByReference($reference)
    {
        $this->addData($this->getResource()->loadByReference($reference));

        return $this;
    }

    /**
     * Return warehouses in specific city.
     *
     * @return array|IV_NovaPoshta_Model_Resource_Entity_Warehouse_Collection
     */
    public function getWarehouses()
    {
        if ($this->getId()) {
            /** @var IV_NovaPoshta_Model_Resource_Entity_Warehouse_Collection $warehouseCollection */
            $warehouseCollection = Mage::getResourceModel('novaposhta/entity_warehouse_collection');
            $warehouseCollection->addFieldToFilter('city_id', $this->getId());

            return $warehouseCollection;
        }

        return array();
    }
}