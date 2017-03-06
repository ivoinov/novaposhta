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
 * Class IV_NovaPoshta_Model_Carrier
 */
class IV_NovaPoshta_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * @var string
     */
    protected $_code = 'novaposhta';

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return array(
            IV_NovaPoshta_Helper_Api::DELIVERY_TYPE_WAREHOUSE_WAREHOUSE => 'Warehouse',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');
        $rateResultMethod = $this->_getWarehouseRate($request);
        if ($rateResultMethod) {
            $result->append($rateResultMethod);
        }

        return $result;
    }

    /**
     * Get Express rate object
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     *
     * @return Mage_Shipping_Model_Rate_Result_Method|false
     */
    protected function _getWarehouseRate(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!empty($request->getDestCity())) {
            $priceRequestProperties = array(
                'CityRecipient'       => $request->getDestCity(),
                'Weight'              => $request->getPackageWeight(),
                'ServiceType'         => IV_NovaPoshta_Helper_Api::DELIVERY_TYPE_WAREHOUSE_WAREHOUSE,
                'Cost'                => $request->getPackageValue(),
                'CargoType'           => IV_NovaPoshta_Helper_Api::CARGO_TYPE_CARGO,
                'SeatsAmount'         => $request->getPackageQty(),
                'RedeliveryCalculate' => array('CargoType' => 'Money', 'Amount' => 100),
            );
            /** @var IV_NovaPoshta_Model_Api_Delivery_Price $priceDeliveryApi */
            $priceDeliveryApi = Mage::getModel('novaposhta/api_delivery_price');
            $priceDeliveryApi->setMethodProperties($priceRequestProperties);
            $priceRequestResult = $priceDeliveryApi->request();
            if (isset($priceRequestResult['Cost'])) {
                /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
                $rate = Mage::getModel('shipping/rate_result_method');
                $rate->setCarrier($this->_code);
                $rate->setCarrierTitle($this->getConfigData('title'));
                $rate->setMethod('WarehouseWarehouse');
                $rate->setMethodTitle('Warehouse');
                $rate->setPrice($priceRequestResult['Cost']);
                $rate->setCost($priceRequestResult['Cost']);

                return $rate;
            }
        }

        return false;
    }
}