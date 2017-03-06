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
 * Class IV_NovaPoshta_Model_Command_SyncCity
 */
class IV_NovaPoshta_Model_Command_SyncCity extends IV_NovaPoshta_Model_Command_SyncAbstract
{
    /**
     * @var integer
     */
    protected $_areaId;
    /**
     * @var IV_NovaPoshta_Model_Entity_Area
     */
    protected $_areaEntity;

    /**
     * {@inheritdoc}
     */
    public function sync()
    {
        $this->_loadArea();
        $this->_removeAll();
        /** @var IV_NovaPoshta_Model_Api_Entity_City $entityApiCity */
        $entityApiCity = Mage::getModel('novaposhta/api_entity_city');
        $entityApiCity->setMethodProperty('AreaRef', $this->_areaEntity->getReference());
        while ($cities = $entityApiCity->request()) {
            foreach ($cities as $city) {
                try {
                    /** @var IV_NovaPoshta_Model_Entity_City $cityModel */
                    $cityModel = Mage::getModel('novaposhta/entity_city');
                    $cityModel->setApiData($city);
                    $cityModel->setAreaId($this->_areaId);
                    $cityModel->save();
                    $this->_syncWarehouses($cityModel);
                } catch (Mage_Core_Exception $e) {
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                    continue;
                } catch (Exception $e) {
                    Mage::logException($e);
                    continue;
                }
            }
        }
        try {
            $this->_areaEntity->setSyncStatus(IV_NovaPoshta_Model_Entity_Area::SUCCESS_SYNC_STATUS);
            $this->_areaEntity->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * Set area IDs for which sync will be running.
     *
     * @param integer $areaId
     */
    public function setAreaId($areaId)
    {
        $this->_areaId = (int)$areaId;
    }

    /**
     * Load area object
     *
     * @return void
     * @throws Exception
     */
    protected function _loadArea()
    {
        /** @var IV_NovaPoshta_Model_Entity_Area|false $area */
        $this->_areaEntity = Mage::getModel('novaposhta/entity_area')->load($this->_areaId);
        if (!$this->_areaEntity || !$this->_areaEntity->getId()) {
            throw new Exception('Area can not be loaded. Check specified area id');
        }
    }

    /**
     * Remove all cities for cpecified region.
     */
    protected function _removeAll()
    {
        /** @var Mage_Core_Model_Resource $resource */
        $resource = Mage::getSingleton('core/resource');
        /** @var Varien_Db_Adapter_Interface $writeConnection */
        $writeConnection = $resource->getConnection('core_write');
        $writeConnection->delete($resource->getTableName('novaposhta/entity_city'),
            array('area_id = ?' => (int)$this->_areaId));
    }

    /**
     * Sync warehouses for specific city.
     *
     * @param IV_NovaPoshta_Model_Entity_City $cityEntity
     */
    protected function _syncWarehouses(IV_NovaPoshta_Model_Entity_City $cityEntity)
    {
        try {
            /** @var IV_NovaPoshta_Model_Command_SyncWarehouses $syncCommand */
            $syncCommand = Mage::getModel('novaposhta/command_syncWarehouses');
            $syncCommand->setCityEntity($cityEntity);
            $syncCommand->sync();
        } catch (Exception $e) {
            Mage::logException($e);

            return;
        }
    }
}