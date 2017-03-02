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
 * Class IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container
 */
class IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container constructor.
     */
    public function __construct()
    {
        $this->_blockGroup = 'novaposhta';
        $this->_controller = 'adminhtml_entities_area_grid_container';
        $this->_headerText = $this->__('Areas');
        parent::__construct();
        $this->_removeButton('add');
        $this->_addButton('sync', array(
            'label'   => $this->__('Sync areas'),
            'onclick' => 'setLocation(\'' . $this->_getSyncUrl() . '\')',
            'class'   => 'sync',
        ));
    }

    /**
     * @return string
     */
    protected function _getSyncUrl()
    {
        return Mage::getUrl('adminhtml/novaposhta/syncAreas');
    }
}