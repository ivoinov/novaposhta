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
    CONST XML_XPATH_IS_ACTIVE        = 'carriers/novaposhta/active';
    CONST UKRAINE_COUNTRY_ISO2_CODDE = 'UA';

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
}