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
 * Class IV_NovaPoshta_Model_Api_Entity_Warehouse
 *
 * @property int                                                $_currentPage
 * @property int                                                $_totalCount
 * @property int                                                $_maxPage
 * @property array                                              $_availableMethodProperties
 * @property IV_NovaPoshta_Helper_Api|Mage_Core_Helper_Abstract $_apiHelper
 * @property resource                                           $_client
 * @property array                                              $_methodProperties
 * @property string                                             $_format
 */
class IV_NovaPoshta_Model_Api_Entity_Warehouse extends IV_NovaPoshta_Model_Api_Abstract
{
    CONST MODEL_NAME    = 'AddressGeneral';
    CONST CALLED_METHOD = 'getWarehouses';
    /**
     * @var array
     */
    protected $_availableMethodProperties
        = array(
            'SettlementRef',
            'CityName',
            'CityRef',
            'Page',
        );

    /**
     * {@inheritdoc}
     */
    public function request()
    {
        parent::_initBodyPostFields();
        $result = curl_exec($this->_client);
        if ($result) {
            $decodedResult = json_decode($result, true);
            if (isset($decodedResult['info']) && isset($decodedResult['info']['totalCount'])
                && is_null($this->_maxPage)
            ) {
                $this->_totalCount = $decodedResult['info']['totalCount'] > $this::MAX_ENTITIES_COUNT
                    ? $decodedResult['info']['totalCount'] : $this::MAX_ENTITIES_COUNT;
                $this->_maxPage = ceil($this->_totalCount / $this::MAX_ENTITIES_COUNT);
            }
            if (isset($decodedResult['data']) && is_array($decodedResult['data'])
                && $this->_currentPage <= $this->_maxPage
            ) {
                $this->_currentPage++;

                return $decodedResult['data'];
            }
        }

        return array();
    }

    /**
     * {@inheritdoc}
     */
    protected function _getCalledMethod()
    {
        return self::CALLED_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getModelName()
    {
        return self::MODEL_NAME;
    }
}