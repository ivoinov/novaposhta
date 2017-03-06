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
 * Class IV_NovaPoshta_Model_Api_Abstract
 */
abstract class IV_NovaPoshta_Model_Api_Abstract
{
    /**
     * Max amount of returned entity, determined by novaposhta api.
     */
    CONST MAX_ENTITIES_COUNT = 150;
    /**
     * @var int
     */
    protected $_currentPage = 1;
    /**
     * @var int
     */
    protected $_totalCount;
    /**
     * @var int
     */
    protected $_maxPage;

    /**
     * @var array
     */
    protected $_availableMethodProperties = array();
    /**
     * @var IV_NovaPoshta_Helper_Api|Mage_Core_Helper_Abstract
     */
    protected $_apiHelper;
    /**
     * @var resource
     */
    protected $_client;
    /**
     * @var string
     */
    protected $_format = 'json';

    /**
     * @var array
     */
    protected $_methodProperties = array();

    /**
     * IV_NovaPoshta_Model_Api_Abstract constructor.
     */
    public function __construct()
    {
        $this->_apiHelper = Mage::helper('novaposhta/api');
        $this->_client = curl_init($this->_getApiUrl());
        curl_setopt($this->_client, CURLOPT_POST, true);
        curl_setopt($this->_client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_client, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($this->_client, CURLOPT_FAILONERROR, true);

    }

    /**
     * Return request api URL.
     *
     * @return string
     */
    protected function _getApiUrl()
    {
        $baseUrl = rtrim($this->_apiHelper->getApiBaseUrl(), '/');

        return implode('/', array($baseUrl, $this->_format, $this->_getModelName(), $this->_getCalledMethod()));
    }

    /**
     * Fetch entities from API.
     *
     * @return array
     */
    abstract public function request();

    /**
     * Return model novaposhta model name.
     *
     * @return string
     */
    abstract protected function _getModelName();

    /**
     * Return novaposhta called method.
     *
     * @return string
     */
    abstract protected function _getCalledMethod();

    /**
     * Reset all method properties.
     *
     * @param array $properties
     */
    public function setMethodProperties(array $properties)
    {
        foreach ($properties as $propertyName => $propertyValue) {
            if (!in_array($propertyName, $this->_availableMethodProperties)) {
                unset($properties[$propertyName]);
            }
        }
        $this->_methodProperties = $properties;
    }

    /**
     * Set specific method property.
     *
     * @param string $propertyName
     * @param string $propertyValue
     */
    public function setMethodProperty($propertyName, $propertyValue)
    {
        if (in_array($propertyName, $this->_availableMethodProperties)) {
            $this->_methodProperties[$propertyName] = $propertyValue;
        }
    }

    /**
     * Init request post body.
     *
     * @return void
     */
    protected function _initBodyPostFields()
    {
        $this->_methodProperties['Page'] = $this->_currentPage;
        $body = array(
            'apiKey'           => $this->_apiHelper->getApiKey(),
            'modelName'        => $this->_getModelName(),
            'calledMethod'     => $this->_getCalledMethod(),
            'methodProperties' => $this->_methodProperties,
        );
        curl_setopt($this->_client, CURLOPT_POSTFIELDS, json_encode($body));
    }
}