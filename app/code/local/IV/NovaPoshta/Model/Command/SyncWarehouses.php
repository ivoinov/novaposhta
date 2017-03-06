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
class IV_NovaPoshta_Model_Command_SyncWarehouses extends IV_NovaPoshta_Model_Command_SyncAbstract
{
    /**
     * @var integer
     */
    protected $_cityId;
    /**
     * @var IV_NovaPoshta_Model_Entity_City
     */
    protected $_cityEntity;

    /**
     * {@inheritdoc}
     */
    public function sync()
    {
        $this->_loadCityEntity();
        /** @var IV_NovaPoshta_Model_Api_Entity_Warehouse $entityApiWarehouse */
        $entityApiWarehouse = Mage::getModel('novaposhta/api_entity_warehouse');
        $entityApiWarehouse->setMethodProperty('SettlementRef', $this->_cityEntity->getReference());
        while ($warehouses = $entityApiWarehouse->request()) {
            foreach ($warehouses as $warehouse) {
                try {
                    /** @var IV_NovaPoshta_Model_Entity_Warehouse $warehouseModel */
                    $warehouseModel = Mage::getModel('novaposhta/entity_warehouse');
                    $warehouseModel->setApiData($warehouse);
                    $warehouseModel->setCityId($this->_cityEntity->getId());
                    $warehouseModel->save();
                } catch (Mage_Core_Exception $e) {
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                    continue;
                } catch (Exception $e) {
                    Mage::logException($e);
                    continue;
                }
            }
        }
    }

    /**
     * Check if city entity loaded and load in case doesn't load.
     *
     * @throws Exception
     * @return void
     */
    protected function _loadCityEntity()
    {
        if (!$this->_isCityEntityLoaded()) {
            $this->_cityEntity = Mage::getModel('novaposhta/entity_city')->load($this->_cityId);
            if (!$this->_isCityEntityLoaded()) {
                throw new Exception('City entity was not loaded. Check city id');
            }
        }


    }

    /**
     * Check if city entity is loaded
     *
     * @return bool
     */
    protected function _isCityEntityLoaded()
    {
        return $this->_cityEntity && $this->_cityEntity->getId();
    }

    /**
     * Set city id
     *
     * @param int $cityId
     *
     * @return void
     */
    public function setCityId($cityId)
    {
        $this->_cityId = $cityId;
    }

    /**
     * Set city entity
     *
     * @param IV_NovaPoshta_Model_Entity_City $city
     *
     * @return void
     */
    public function setCityEntity(IV_NovaPoshta_Model_Entity_City $city)
    {
        $this->_cityEntity = $city;
    }
}