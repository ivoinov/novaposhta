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
 * Class IV_NovaPoshta_Model_Resource_Directory_Region_Collection
 */
class IV_NovaPoshta_Model_Resource_Directory_Region_Collection extends Mage_Directory_Model_Resource_Region_Collection
{
    /**
     * {@inheritdoc}
     */
    protected function _afterLoad()
    {
        /** @var IV_NovaPoshta_Model_Resource_Entity_Area_Collection $areaCollection */
        $areaCollection = Mage::getResourceModel('novaposhta/entity_area_collection');
        $areaCollection->addFieldToFilter('sync_status', array(
            array('eq' => IV_NovaPoshta_Model_Entity_Area::SUCCESS_SYNC_STATUS),
            array('eq' => IV_NovaPoshta_Model_Entity_Area::NEED_UPDATE_SYNC_STATUS),
        ));
        foreach ($areaCollection as $area) {
            /** @var IV_NovaPoshta_Model_Entity_Area $area */
            $this->addItem(Mage::getModel('directory/region')->setData(array(
                'region_id'    => $this->_getRegionId($area->getId()),
                'country_id'   => IV_NovaPoshta_Helper_Data::UKRAINE_COUNTRY_ISO2_CODDE,
                'code'         => $area->getReference(),
                'default_name' => $area->getDescription(),
            )));
        }

        return parent::_afterLoad();
    }

    /**
     * Return region id with prefix to avoid duplicate with default directory module.
     *
     * @param int $regionId
     *
     * @return string
     */
    protected function _getRegionId($regionId)
    {
        return sprintf('%s%s', IV_NovaPoshta_Helper_Data::NOVAPOSHTA_REGION_ID_PREFIX, $regionId);
    }
}