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
 * Class IV_NovaPoshta_AreaController
 */
class IV_NovaPoshta_AreaController extends Mage_Core_Controller_Front_Action
{
    /**
     * Return cities for specific region or all cities.
     *
     * @return IV_NovaPoshta_AreaController $this
     */
    public function getCitiesAction()
    {
        $this->getResponse()->clearHeaders();
        $this->getResponse()->setHeader('Content-type', 'application/json');
        /** @var IV_NovaPoshta_Model_Entity_Area $areaEntity */
        $areaEntity = Mage::getModel('novaposhta/entity_area')->load($this->_getAreaId());
        if ($areaEntity && $areaEntity->getId()) {
            /** @var IV_NovaPoshta_Model_Resource_Entity_City_Collection $cities */
            $cities = $areaEntity->getCities();
            $this->getResponse()->setBody(json_encode($cities->toArray('reference', 'description')));
        }
        $this->getResponse()->setBody(Mage::helper('novaposhta')->getCitiesJson());

        return $this;
    }

    /**
     * Return area id without prefix.
     *
     * @return int
     */
    protected function _getAreaId()
    {
        $areaId = $this->getRequest()->getParam('area_id');

        return (int)str_replace(IV_NovaPoshta_Helper_Data::NOVAPOSHTA_REGION_ID_PREFIX, '', $areaId);
    }
}