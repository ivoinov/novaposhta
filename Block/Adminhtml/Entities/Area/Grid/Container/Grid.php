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
 * Class IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container_Grid
 */
class IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('id');
        $this->setId('novaposhta_entity_area_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * {@inheritdoc}
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getResourceModel('novaposhta/entity_area_collection'));

        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     * @return IV_NovaPoshta_Block_Adminhtml_Entities_Area_Grid_Container_Grid|Mage_Adminhtml_Block_Widget_Grid $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('novaposhta')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'id',
        ));

        $this->addColumn('description', array(
            'header' => $this->__('Name'),
            'index'  => 'description',
        ));
        $this->addColumn('reference', array(
            'header' => Mage::helper('novaposhta')->__('Novaposhta reference'),
            'index'  => 'reference',
        ));
        $this->addColumn('areas_center', array(
            'header' => Mage::helper('novaposhta')->__('Area center reference'),
            'index'  => 'areas_center',
        ));

        $this->addColumn('sync_status', array(
            'header'           => Mage::helper('novaposhta')->__('Status'),
            'width'            => '120px',
            'align'            => 'left',
            'index'            => 'sync_status',
            'type'             => 'options',
            'options'          => Mage::helper('novaposhta')->getAreaSyncStatuses(),
            'frame_callback'   => array($this, 'decorateStatus'),
            'column_css_class' => 'sync_status',
        ));
        $this->addColumn('action', array(
            'header'    => Mage::helper('novaposhta')->__('Action'),
            'width'     => '80',
            'align'     => 'center',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('novaposhta')->__('Update cities'),
                    'url'     => array('base' => '*/*/syncCities'),
                    'field'   => 'area_id',
                ),
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
        ));


        return parent::_prepareColumns();
    }

    /**
     * Decorate status column.
     *
     * @param string                          $value
     * @param IV_NovaPoshta_Model_Entity_Area $area
     *
     * @return string
     */
    public function decorateStatus($value, IV_NovaPoshta_Model_Entity_Area $area)
    {
        $statuses = Mage::helper('novaposhta')->getAreaSyncStatuses();
        switch ($area->getSyncStatus()) {
            case IV_NovaPoshta_Model_Entity_Area::FAILED_SYNC_STATUS:
                $color = '#FF0000';
                break;
            case IV_NovaPoshta_Model_Entity_Area::SUCCESS_SYNC_STATUS:
                $color = '#3FB853';
                break;
            case IV_NovaPoshta_Model_Entity_Area::NEED_UPDATE_SYNC_STATUS:
                $color = '#FFA500';
                break;
            default:
                $color = '#000000';
        }
        $html = '<div style="margin-top: 1px; width: 120px; height: 16px; background: ' . $color
            . '; border-radius: 0px">';
        $html .= '<div style="width: 120px; height: 16px; color: #FFFFFF; text-align: center; font: bold 10px/16px Arial, Helvetica, sans-serif; text-transform: uppercase">';
        $html .= (isset($statuses[$area->getSyncStatus()]) ? $statuses[$area->getSyncStatus()]
            : $area->getSyncStatus());
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}