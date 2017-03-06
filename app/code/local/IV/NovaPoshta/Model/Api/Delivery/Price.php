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
class IV_NovaPoshta_Model_Api_Delivery_Price extends IV_NovaPoshta_Model_Api_Abstract
{
    CONST MODEL_NAME    = 'InternetDocument';
    CONST CALLED_METHOD = 'getDocumentPrice';
    /**
     * @var array
     */
    protected $_availableMethodProperties
        = array(
            'CitySender',
            'CityRecipient',
            'Weight',
            'ServiceType',
            'Cost',
            'CargoType',
            'SeatsAmount',
            'RedeliveryCalculate',
        );

    public function request()
    {
        $this->_initBodyPostFields();
        $result = curl_exec($this->_client);
        if ($result) {
            $decodedResult = json_decode($result, true);
            if (isset($decodedResult['success']) && $decodedResult['success'] === true
                && !empty($decodedResult['data'] && !empty($decodedResult['data'][0]))
            ) {
                return $decodedResult['data'][0];
            }
        }

        return array();
    }

    protected function _initBodyPostFields()
    {
        $this->_methodProperties['CitySender'] = $this->_apiHelper->getCitySenderReference();
        $body = array(
            'apiKey'           => $this->_apiHelper->getApiKey(),
            'modelName'        => $this->_getModelName(),
            'calledMethod'     => $this->_getCalledMethod(),
            'methodProperties' => $this->_methodProperties,
        );
        curl_setopt($this->_client, CURLOPT_POSTFIELDS, json_encode($body));
    }

    protected function _getModelName()
    {
        return self::MODEL_NAME;
    }

    protected function _getCalledMethod()
    {
        return self::CALLED_METHOD;
    }
}