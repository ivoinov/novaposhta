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
 * Class IV_NovaPoshta_Helper_Api
 */
class IV_NovaPoshta_Helper_Api extends Mage_Core_Helper_Abstract
{
    CONST XML_XPATH_API_KEY      = 'carriers/novaposhta/api_key';
    CONST XML_XPATH_API_BASE_URL = 'carriers/novaposhta/api_url';
    CONST XML_XPATH_CITY_SENDER  = 'carriers/novaposhta/city_sender';

    /**
     * {@link https://devcenter.novaposhta.ua/docs/services/55702570a0fe4f0cf4fc53ed/operations/55702571a0fe4f0b6483890e}
     */
    CONST DELIVERY_TYPE_DOORS_DOORS         = 'DoorsDoors';
    CONST DELIVERY_TYPE_DOORS_WAREHOUSE     = 'DoorsWarehouse';
    CONST DELIVERY_TYPE_WAREHOUSE_WAREHOUSE = 'WarehouseWarehouse';
    CONST DELIVERY_TYPE_WAREHOUSE_DOORS     = 'WarehouseDoors';

    /**
     * {@link https://devcenter.novaposhta.ua/docs/services/55702570a0fe4f0cf4fc53ed/operations/55702571a0fe4f0b64838909}
     */
    CONST CARGO_TYPE_CARGO        = 'Cargo';
    CONST CARGO_TYPE_DOCUMENTS    = 'Documents';
    CONST CARGO_TYPE_TIRES_WHEELS = 'TiresWheels';
    CONST CARGO_TYPE_PALLET       = 'Pallet';

    /**
     * Return api base url.
     *
     * @return string
     */
    public function getApiBaseUrl()
    {
        return (string)Mage::getStoreConfig(self::XML_XPATH_API_BASE_URL);
    }

    /**
     * Return api secret key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return (string)Mage::getStoreConfig(self::XML_XPATH_API_KEY);
    }

    public function getCitySenderReference()
    {
        return (string)Mage::getStoreConfig(self::XML_XPATH_CITY_SENDER);
    }
}