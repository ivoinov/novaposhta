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
 * Class IV_NovaPoshta_Adminhtml_NovaposhtaController
 */
class IV_NovaPoshta_Adminhtml_NovaposhtaController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Shows areas grid.
     *
     * @return void
     */
    public function areasAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Shows city grid
     *
     * @return void
     */
    public function citiesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Show all warehouse grid
     *
     * @return void
     */
    public function warehousesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @return void
     */
    public function syncAreasAction()
    {
        try {
            /** @var IV_NovaPoshta_Model_Command_SyncAreas $syncCommand */
            $syncCommand = Mage::getModel('novaposhta/command_syncAreas');
            $syncCommand->sync();
            $this->_redirect('*/*/areas');
        } catch (Mage_Core_Exception $e) {

        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function syncCitiesAction()
    {
        try {
            $areaId = $this->getRequest()->getParam('area_id');
            /** @var IV_NovaPoshta_Model_Command_SyncCity $syncCommand */
            $syncCommand = Mage::getModel('novaposhta/command_syncCity');
            $syncCommand->setAreaId($areaId);
            $syncCommand->sync();
            $this->_redirect('*/*/cities');
        } catch (Mage_Core_Exception $e) {

        } catch (Exception $e) {
        }
    }
}