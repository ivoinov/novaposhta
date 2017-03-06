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
 * Class IV_NovaPoshta_Model_Observer
 */
class IV_NovaPoshta_Model_Observer
{

    /**
     * Save additional information (novaposhta warehouse id) to quote payment.
     *
     * @param Varien_Event_Observer $observer
     */
    public function saveNovaposhtaWarehouse(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Quote|false $quote */
        $quote = $observer->getEvent()->getQuote();
        $warehouseId = Mage::app()->getRequest()
            ->getParam(IV_NovaPoshta_Block_Carrier_Warehouses::NOVAPOSHTA_WAREHOUSES_INPUT_NAME);
        if ($quote && !empty($warehouseId)) {
            $quote->getPayment()->setAdditionalInformation('novaposhta_warehouse_id', $warehouseId);
        }
    }
}