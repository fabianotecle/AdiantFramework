<?php
/**
 * FuturoPrevidenciaTagsView
 *
 * @version    1.0
 * @package    control
 * @subpackage FuturoPrevidenciaView
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaTagsView extends TStandardList
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        
        parent::setDatabase('futuro_previdencia');    // defines the database
        parent::setActiveRecord('FuturoPrevidenciaTag');    // defines the active record
        parent::setDefaultOrder('id_tag', 'desc');        // defines the default order
        parent::addFilterField('id_tag', '=', 'id_tag');      // filterField, operator, formField
        parent::addFilterField('tag', 'like', 'tag'); // filterField, operator, formField
        
        $this->form = new BootstrapFormBuilder('tag_list_form');
        $this->form->setFormTitle("Tags");
        
        $id = new TEntry('id_tag');
        $tag = new TEntry('tag');

        $id->setSize('100%');
        $tag->setSize('100%');

        $row2 = $this->form->addFields([new TLabel("ID:", null, '14px', null, '100%'),$id],
                                       [new TLabel("Tag" . ":", null, '14px', null, '100%'),$tag]);
        $row2->layout = [' col-sm-2', 'col-sm-10'];

        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction(_t("Search"), new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 
        
        $btn_onshow = $this->form->addAction(_t("New"), new TAction(['FuturoPrevidenciaTagsForm', 'onEdit']), 'fas:plus #69aa46');
        
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        
        $column_id = new TDataGridColumn('id_tag', "ID", 'center' , '70px');
        $column_tag = new TDataGridColumn('tag', "Tag", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id_tag');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_tag);

        $action_onEdit = new TDataGridAction(['FuturoPrevidenciaTagsForm', 'onEdit'], ['register_state' => 'false']);
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel(_t("Edit"));
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField('id_tag');
      
        $action_onDelete = new TDataGridAction(['FuturoPrevidenciaTagsView', 'onDelete'], [ 'register_state' => 'false']);
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel(_t("Delete"));
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField('id_tag');
      
        $this->datagrid->addAction($action_onEdit);
        $this->datagrid->addAction($action_onDelete);
        $this->datagrid->createModel();

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'FuturoPrevidenciaTagsView' ));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);
    }
    
    /**
     * Ask before delete record
     */
    public function onDelete($param = null) 
    { 
        if (isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                $key = $param['key'];
                TTransaction::open('futuro_previdencia');
                $object = new FuturoPrevidenciaTag($key, FALSE); 
                $object->delete();
                TTransaction::close();

                $this->onReload( $param );
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e)
            {
                new TMessage('error', $e->getMessage());
                TTransaction::rollback();
            }
        }
        else
        {
            $action = new TAction(array($this, 'onDelete'), [ 'register_state' => 'false']);
            $action->setParameters($param);
            $action->setParameter('delete', 1);
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
}
