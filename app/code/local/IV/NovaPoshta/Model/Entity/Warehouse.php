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
 * Class IV_NovaPoshta_Model_Entity_Warehouse
 * @method IV_NovaPoshta_Model_Entity_Warehouse setReference(string $reference)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setCode(string $code)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setDescription(string $description)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setPhone(string $phone)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setType(string $type)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setCityId(integer $cityId)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setCityName(string $cityName)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setLatitude(float $latitude)
 * @method IV_NovaPoshta_Model_Entity_Warehouse setLongitude(float $longitude)
 * @method string getReference()
 * @method string getCode()
 * @method string getDescription()
 * @method string getPhone()
 * @method string getType()
 * @method integer getCityId()
 * @method string getCityName()
 * @method float getLatitude()
 * @method float getLongitude()
 */
class IV_NovaPoshta_Model_Entity_Warehouse extends IV_NovaPoshta_Model_Entity_Abstract
{
    /**
     * @var array
     */
    protected $_attributeMapping
        = array(
            'Ref'             => 'reference',
            'Description'     => 'description',
            'SiteKey'         => 'code',
            'Phone'           => 'phone',
            'TypeOfWarehouse' => 'type',
            'CityDescription' => 'city_name',
            'Longitude'       => 'latitude',
            'Latitude'        => 'longitude',
        );
    /**
     * @var string
     */
    protected $_eventObject = 'warehouse';
    /**
     * @var string
     */
    protected $_eventPrefix = 'novaposhta_warehouse';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('novaposhta/entity_warehouse');
        parent::_construct();
    }
}