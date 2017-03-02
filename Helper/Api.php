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
}