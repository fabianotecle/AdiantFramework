<?php
/**
 * FuturoPrevidenciaView
 *
 * @version    1.0
 * @package    control
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaView extends TStandardList
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
        
        parent::setDatabase('futuro_previdencia');               // defines the database
        parent::setActiveRecord('FuturoPrevidenciaClientes');    // defines the active record
        parent::setDefaultOrder('id_cliente', 'desc');           // defines the default order
        parent::addFilterField('id_cliente', '=', 'id_cliente'); // filterField, operator, formField
        parent::addFilterField('nome', 'like', 'nome');       // filterField, operator, formField
        parent::addFilterField('celular', 'like', 'celular'); // filterField, operator, formField
        parent::addFilterField('email', 'like', 'email');     // filterField, operator, formField
        parent::addFilterField('cidade', 'in', '(select cidade from endereco)'); // filterField, operator, formField
        parent::addFilterField('uf', 'in', '(select uf from endereco)'); // filterField, operator, formField
        parent::addFilterField('cep', 'in', '(select cep from endereco)'); // filterField, operator, formField
        parent::addFilterField('tag', 'in', '(select tag from tag)');    // filterField, operator, formField
        
        $this->form = new BootstrapFormBuilder('futuro_previdencia_form');
        $this->form->setFormTitle("Clientes/Leads");
        
        $id = new TEntry('id_cliente');
        $nome = new TEntry('nome');
        $cel = new TEntry('celular');
        $email = new TEntry('email');
        $cidade = new TEntry('cidade');
        $uf = new TCombo('uf');
        $cep = new TEntry('cep');
        $tag = new TEntry('id_tag');

        $model = new FuturoPrevidenciaClientes(); 
        $ufs = $model->getUFs();
        $uf->addItems($ufs);

        $id->setSize('100%');
        $nome->setSize('100%');
        $cel->setSize('100%');
        $email->setSize('100%');
        $cidade->setSize('100%');
        $uf->setSize('100%');
        $cep->setSize('100%');
        $tag->setSize('100%');

        $row2 = $this->form->addFields([new TLabel("ID:", null, '14px', null, '100%'),$id],
                                       [new TLabel(_t("Name") . ":", null, '14px', null, '100%'),$nome],
                                       [new TLabel("Celular" . ":", null, '14px', null, '100%'),$cel],
                                       [new TLabel("E-mail" . ":", null, '14px', null, '100%'),$email],
                                       [new TLabel("Cidade" . ":", null, '14px', null, '100%'),$cidade],
                                       [new TLabel("UF" . ":", null, '14px', null, '100%'),$uf],
                                       [new TLabel("CEP" . ":", null, '14px', null, '100%'),$cep],
                                       [new TLabel("Tag" . ":", null, '14px', null, '100%'),$tag]);
        $row2->layout = [' col-sm-2', ' col-sm-5',' col-sm-2',' col-sm-3',' col-sm-5', ' col-sm-2',' col-sm-3',' col-sm-2'];

        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction(_t("Search"), new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 
        
        $btn_onshow = $this->form->addAction(_t("New"), new TAction(['FuturoPrevidenciaForm', 'onEdit']), 'fas:plus #69aa46');
        
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        
        $column_id = new TDataGridColumn('id_cliente', "ID", 'center' , '70px');
        $column_nome = new TDataGridColumn('nome', _t("Name"), 'left');
        $column_contatos = new TDataGridColumn('{celular} - {email}', "Contato", 'center');
        $column_enderecos = new TDataGridColumn('', "Endereços", 'center' , '250px');
        $column_tags = new TDataGridColumn('', "Tags", 'center' , '100px');

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_contatos);
        $this->datagrid->addColumn($column_enderecos);
        $this->datagrid->addColumn($column_tags);

        $action_onEdit = new TDataGridAction(['FuturoPrevidenciaForm', 'onEdit'], ['register_state' => 'false']);
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel(_t("Edit"));
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField('id_cliente');
        
        $action_onDelete = new TDataGridAction(['FuturoPrevidenciaView', 'onDelete'], [ 'register_state' => 'false']);
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel(_t("Delete"));
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField('id_cliente');
        
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
        $container->add(new TXMLBreadCrumb('menu.xml', 'FuturoPrevidenciaView' ));
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
                $object = new FuturoPrevidenciaClientes($key, FALSE); 
                $object->unsetEnderecos($key);
                $object->unsetTags($key);
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
