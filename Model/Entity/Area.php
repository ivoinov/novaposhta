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
 * Class IV_NovaPoshta_Model_Entities_Area
 * @method IV_NovaPoshta_Model_Entity_Area setDescription(string $description)
 * @method IV_NovaPoshta_Model_Entity_Area setReference(string $reference)
 * @method IV_NovaPoshta_Model_Entity_Area setAreasCenter(string $areasCenter)
 * @method IV_NovaPoshta_Model_Entity_Area setSyncStatus(boolean $isSynced)
 * @method IV_NovaPoshta_Model_Entity_Area setSyncedAt(string $syncedAt)
 * @method string getDescription()
 * @method string getReference()
 * @method string getAreasCenter()
 * @method boolean getSyncStatus()
 * @method boolean getSyncedAt()
 * @method setApiData(array $apiData)
 */
class IV_NovaPoshta_Model_Entity_Area extends IV_NovaPoshta_Model_Entity_Abstract
{
    CONST SUCCESS_SYNC_STATUS     = 1;
    CONST NEED_UPDATE_SYNC_STATUS = 2;
    CONST FAILED_SYNC_STATUS      = 0;

    /**
     * @var array
     */
    protected $_attributeMapping
        = array(
            'Ref'         => 'reference',
            'Description' => 'description',
            'AreasCenter' => 'areas_center',
        );

    /**
     * @var string
     */
    protected $_eventObject = 'area';
    /**
     * @var string
     */
    protected $_eventPrefix = 'novaposhta_area';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('novaposhta/entity_area');
        parent::_construct();
    }
}