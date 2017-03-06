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
 * Class IV_NovaPoshta_Model_Command_SyncAreas
 */
class IV_NovaPoshta_Model_Command_SyncAreas extends IV_NovaPoshta_Model_Command_SyncAbstract
{
    /**
     * {@inheritdoc}
     */
    public function sync()
    {
        $this->_removeAll();
        $entityApiArea = Mage::getModel('novaposhta/api_entity_area');
        $areas = $entityApiArea->request();
        foreach ($areas as $area) {
            try {
                /** @var IV_NovaPoshta_Model_Entity_Area $areaModel */
                $areaModel = Mage::getModel('novaposhta/entity_area');
                $areaModel->setApiData($area);
                $areaModel->setSyncStatus(IV_NovaPoshta_Model_Entity_Area::NEED_UPDATE_SYNC_STATUS);
                $areaModel->setSyncedAt(Mage::getModel('core/date')->gmtDate());
                $areaModel->save();
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                continue;
            } catch (Exception $e) {
                Mage::logException($e);
                continue;
            }
        }
        Mage::getSingleton('core/session')->addSuccess('Areas have been successfully synced');
    }

    /**
     * Remove all data from the table.
     *
     * @return void
     */
    protected function _removeAll()
    {
        /** @var Mage_Core_Model_Resource $resource */
        $resource = Mage::getSingleton('core/resource');
        /** @var Varien_Db_Adapter_Interface $writeConnection */
        $writeConnection = $resource->getConnection('core_write');
        $writeConnection->delete($resource->getTableName('novaposhta/entity_area'));
        $writeConnection->changeTableAutoIncrement($resource->getTableName('novaposhta/entity_area'), 0);
    }
}