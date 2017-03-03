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
 * Class IV_NovaPoshta_Model_Entity_Abstract
 */
abstract class IV_NovaPoshta_Model_Entity_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Mapping between attributes received from API and magento entity attributes.
     *
     * @var array
     */
    protected $_attributeMapping = array();

    /**
     * Set magento data depends on maaping.
     *
     * @param array $data
     */
    public function setApiData(array $data)
    {
        foreach ($data as $key => $value) {
            if (isset($this->_attributeMapping[$key])) {
                $key = $this->_attributeMapping[$key];
            }
            $this->setData($key, $value);
        }
    }
}