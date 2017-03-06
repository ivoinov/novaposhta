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
 * Class IV_NovaPoshta_WarehouseController
 */
class IV_NovaPoshta_WarehouseController extends Mage_Core_Controller_Front_Action
{
    /**
     * Return list of warehouses for specific city.
     *
     * @return IV_NovaPoshta_WarehouseController $this
     */
    public function getWarehousesAction()
    {
        $this->getResponse()->clearHeaders();
        $this->getResponse()->setHeader('Content-type', 'application/json');
        if ($this->getRequest()->isAjax()) {
            /** @var IV_NovaPoshta_Model_Entity_City|false $city */
            $city = $this->_getCityEntity();
            if ($city) {
                $warehouses = $city->getWarehouses();
                if (!empty($warehouses)) {
                    $this->getResponse()->setBody(json_encode($warehouses->toArray()));

                    return $this;
                }
            }
            $this->getResponse()->setBody(json_encode(array()));
        } else {
            $this->getResponse()->setBody($this->__('Only ajax calls are allowed'));
        }

        return $this;
    }

    /**
     * Return city entity loadl by reference.
     *
     * @return IV_NovaPoshta_Model_Entity_City
     */
    protected function _getCityEntity()
    {
        $cityReference = $this->getRequest()->getParam('reference', null);

        return Mage::getModel('novaposhta/entity_city')->loadByReference($cityReference);
    }
}