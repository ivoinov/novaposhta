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
 * Class IV_NovaPoshta_Block_Carrier_Warehouses
 */
class IV_NovaPoshta_Block_Carrier_Warehouses extends Mage_Core_Block_Template
{
    CONST DEFAULT_BLOCK_TEMPLATE_PATH      = 'novaposhta/carrier/warehouses.phtml';
    CONST NOVAPOSHTA_WAREHOUSES_INPUT_NAME = 'novaposhta_warehouse';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        if (!$this->hasData('template')) {
            $this->setTemplate($this::DEFAULT_BLOCK_TEMPLATE_PATH);
        }
    }

    /**
     * Return available warehouses.
     *
     * @return array|IV_NovaPoshta_Model_Resource_Entity_Warehouse_Collection
     */
    public function getAvailableWarehouses()
    {
        /** @var Mage_Checkout_Model_Type_Onepage $checkout */
        $checkout = Mage::getSingleton('checkout/type_onepage');
        if ($checkout) {
            /** @var Mage_Sales_Model_Quote $currentQuote */
            $currentQuote = $checkout->getQuote();
            if ($currentQuote) {
                /** @var Mage_Sales_Model_Quote_Address $shippingAddress */
                $shippingAddress = $currentQuote->getShippingAddress();
                $cityReference = $shippingAddress->getCity();
                $cityEntity = Mage::getModel('novaposhta/entity_city')->loadByReference($cityReference);
                if ($cityEntity && $cityEntity->getId()) {
                    return $cityEntity->getWarehouses();
                }
            }
        }

        return array();
    }

    /**
     * Return wareouse input name on checkout.
     *
     * @return string
     */
    public function getWarehouseInputName()
    {
        return $this::NOVAPOSHTA_WAREHOUSES_INPUT_NAME;
    }
}