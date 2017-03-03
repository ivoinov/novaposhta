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
 * Class IV_NovaPoshta_Model_Resource_Entity_City_Collection
 */
class IV_NovaPoshta_Model_Resource_Entity_City_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @var string
     */
    protected $_eventObject = 'city_collection';
    /**
     * @var string
     */
    protected $_eventPrefix = 'novaposhta_city_collection';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('novaposhta/entity_city');
    }

    /**
     * Join region table and include region info to city entity.
     *
     * @param bool $isIncludeRegionInfo
     *
     * @return $this
     */
    public function includeRegionInfo($isIncludeRegionInfo = true)
    {
        if ($isIncludeRegionInfo) {
            $this->getSelect()->join(array('nea' => $this->getResource()->getTable('novaposhta/entity_area')),
                'main_table.area_id = nea.id', array(
                    'region_name'             => 'nea.description',
                    'region_reference'        => 'nea.reference',
                    'region_center_reference' => 'nea.areas_center',
                    'region_sync_status'      => 'nea.sync_status',
                    'region_synced_at'        => 'nea.synced_at',
                ));
        }

        return $this;
    }
}