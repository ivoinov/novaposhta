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
 * Class IV_NovaPoshta_Helper_Data
 */
class IV_NovaPoshta_Helper_Data extends Mage_Core_Helper_Abstract
{
    CONST XML_XPATH_IS_ACTIVE         = 'carriers/novaposhta/active';
    CONST UKRAINE_COUNTRY_ISO2_CODDE  = 'UA';
    CONST CITIES_JSON_CACHE_KEY       = 'NOVAPOSHTA_CITIES_JSON';
    CONST NOVAPOSHTA_REGION_ID_PREFIX = 'novashta_';
    /**
     * @var string
     */
    protected $_citiesJson;

    /**
     * @return bool
     */
    public function isCarrierActive()
    {
        return Mage::getStoreConfigFlag(self::XML_XPATH_IS_ACTIVE);
    }

    /**
     * Return area sync statuses
     *
     * @return array
     */
    public function getAreaSyncStatuses()
    {
        return array(
            IV_NovaPoshta_Model_Entity_Area::SUCCESS_SYNC_STATUS     => Mage::helper('novaposhta')->__('Up to date'),
            IV_NovaPoshta_Model_Entity_Area::FAILED_SYNC_STATUS      => Mage::helper('novaposhta')->__('Failed'),
            IV_NovaPoshta_Model_Entity_Area::NEED_UPDATE_SYNC_STATUS => Mage::helper('novaposhta')
                ->__('Update required'),
        );
    }

    /**
     * @return string
     */
    public function getCitiesJson()
    {
        if (is_null($this->_citiesJson)) {
            if (Mage::app()->useCache('config')) {
                $json = Mage::app()->loadCache(self::CITIES_JSON_CACHE_KEY);
            }
            if (empty($json)) {
                $cities = $this->_getCities();
                $json = Mage::helper('core')->jsonEncode($cities);

                if (Mage::app()->useCache('config')) {
                    Mage::app()->saveCache($json, self::CITIES_JSON_CACHE_KEY, array('config'));
                }
            }
            $this->_citiesJson = $json;
        }

        return $this->_citiesJson;
    }

    /**
     * Return all cities in array (area reference => citiesArray())
     *
     * @return array
     */
    protected function _getCities()
    {
        $cities = array();
        /** @var IV_NovaPoshta_Model_Resource_Entity_City_Collection $cityCollection */
        $cityCollection = Mage::getResourceModel('novaposhta/entity_city_collection');
        $cityCollection->includeRegionInfo(true);
        foreach ($cityCollection as $city) {
            /** @var IV_NovaPoshta_Model_Entity_City $city */
            $cities[$city->getRegionReference()][] = array(
                'id'        => $city->getId(),
                'reference' => $city->getReference(),
                'name'      => $city->getDescription(),
                'latitude'  => $city->getLatitude(),
                'longitude' => $city->getLongitude(),
            );
        }

        return $cities;
    }
}