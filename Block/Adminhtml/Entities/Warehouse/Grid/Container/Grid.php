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
 * Class IV_NovaPoshta_Block_Adminhtml_Entities_Warehouse_Grid_Container_Grid
 */
class IV_NovaPoshta_Block_Adminhtml_Entities_Warehouse_Grid_Container_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * IV_NovaPoshta_Block_Adminhtml_Entities_Warehouse_Grid_Container_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('id');
        $this->setId('novaposhta_entity_warehouse_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * {@inheritdoc}
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getResourceModel('novaposhta/entity_warehouse_collection'));

        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     * @return IV_NovaPoshta_Block_Adminhtml_Entities_Warehouse_Grid_Container_Grid|Mage_Adminhtml_Block_Widget_Grid $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => $this->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'id',
        ));

        $this->addColumn('description', array(
            'header' => $this->__('Name'),
            'index'  => 'description',
        ));
        $this->addColumn('city_name', array(
            'header' => $this->__('City name'),
            'index'  => 'city_name',
        ));
        $this->addColumn('phone', array(
            'header' => $this->__('Phone'),
            'index'  => 'phone',
        ));
        $this->addColumn('code', array(
            'header' => $this->__('Code'),
            'index'  => 'code',
        ));
        $this->addColumn('reference', array(
            'header' => $this->__('Novaposhta reference'),
            'index'  => 'reference',
        ));
        $this->addColumn('latitude', array(
            'header' => $this->__('Latitude'),
            'index'  => 'latitude',
        ));
        $this->addColumn('longitude', array(
            'header' => $this->__('Longitude'),
            'index'  => 'longitude',
        ));

        return parent::_prepareColumns();
    }
}