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
 * Class IV_NovaPoshta_Model_Entity_Source_City
 */
class IV_NovaPoshta_Model_Entity_Source_City
{
    /**
     * @var array
     */
    protected $_options = array();

    /**
     * Return all cities.
     *
     * @return array
     */
    public function toOptionArray()
    {
        /** @var IV_NovaPoshta_Model_Resource_Entity_City_Collection $cityCollection */
        $cityCollection = Mage::getResourceModel('novaposhta/entity_city_collection');
        if (empty($this->_options)) {
            foreach ($cityCollection as $city) {
                /** @var IV_NovaPoshta_Model_Entity_City */
                $this->_options[] = array('value' => $city->getReference(), 'label' => $city->getDescription());
            }
        }

        return $this->_options;
    }
}