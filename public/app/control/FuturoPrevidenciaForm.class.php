<?php
/**
 * FuturoPrevidenciaForm
 *
 * @version    1.0
 * @package    control
 * @subpackage FuturoPrevidenciaForm
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaForm extends TPage
{
    protected $form;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        parent::setTargetContainer('adianti_right_panel');

        $this->form = new BootstrapFormBuilder('futuro_previdencia_clientes_form');
        $this->form->setFormTitle('Clientes/Leads');

        $id = new THidden('id_cliente');
        $nome = new TEntry('nome');
        $cel = new TEntry('celular');
        $email = new TEntry('email');
        
        $nome->setSize('100%');
        $cel->setSize('100%');
        $email->setSize('100%');

        $this->form->appendPage("Cliente/Lead");
        
        $this->form->addFields([$id]);
        $row1 = $this->form->addFields([new TLabel("Nome" . ':', '#ff0000', '14px', null, '100%'),$nome],
                                       [new TLabel("celular" . ":", '#ff0000', '14px', null, '100%'),$cel],
                                       [new TLabel("Email" . ":", '#ff0000', '14px', null, '100%'),$email]);
        $row1->layout = ['col-sm-12', 'col-sm-6', 'col-sm-6'];
        
        $this->form->appendPage("Endereços");

        $id_endereco = new THidden('id_endereco');
        $cep = new TEntry('cep');
        $rua = new TEntry('rua');
        $numero = new TEntry('numero');
        $complemento = new TEntry('complemento');
        $bairro = new TEntry('bairro');
        $cidade = new TEntry('cidade');
        $uf = new TEntry('uf');

        $cep->setSize('100%');
        $rua->setSize('100%');
        $numero->setSize('100%');
        $complemento->setSize('100%');
        $bairro->setSize('100%');
        $cidade->setSize('100%');
        $uf->setSize('100%');

        $row4 = $this->form->addFields([new TLabel("CEP" . ':', '#ff0000', '14px', null, '100%'),$cep],
                                       [new TLabel("Logradouro" . ':', '#ff0000', '14px', null, '100%'),$rua],
                                       [new TLabel("Número" . ':', '#ff0000', '14px', null, '100%'),$numero],
                                       [new TLabel("Complemento" . ':', '#ff0000', '14px', null, '100%'),$complemento],
                                       [new TLabel("Bairro" . ':', '#ff0000', '14px', null, '100%'),$bairro],
                                       [new TLabel("Cidade" . ':', '#ff0000', '14px', null, '100%'),$cidade],
                                       [new TLabel("UF" . ':', '#ff0000', '14px', null, '100%'),$uf]);
        $row4->layout = ['col-sm-2', 'col-sm-5', 'col-sm-2', 'col-sm-3', 'col-sm-5', 'col-sm-5', 'col-sm-2'];
        
        
        $this->form->appendPage("Tags");
        
        $this->tags = new TCheckList('tags');
        $this->tags->setIdColumn('id_tag');
        $this->tags->addColumn('id_tag',    'ID',    'center',  '10%');
        $this->tags->addColumn('tag', 'TAG',    'left',   '50%');
        $this->tags->setHeight(350);
        $this->tags->makeScrollable();

        $model = new FuturoPrevidenciaClientes(); 
        $this->tags->addItems($model->getTags());
        
        $row5 = $this->form->addFields([$this->tags]);
        $row5->layout = [' col-sm-12'];
        
        $btn_onsave = $this->form->addAction(_t("Save"), new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 
        $btn_onshow = $this->form->addAction(_t("Back"), new TAction(['FuturoPrevidenciaView', 'onReload']), 'fas:arrow-left #000000');
        
        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel(_t("Close"));
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);
    }
    
    /**
     * on save
     */
    public function onSave() 
    {
        try
        {
            TTransaction::open('futuro_previdencia');
            $this->form->validate();
            $object = new FuturoPrevidenciaClientes();
            $data = $this->form->getData();
            
            $object->fromArray( (array) $data);
            $object->store();

            $object->unsetEnderecos($object->id_cliente);

            if (!empty($data->enderecos))
            {
                foreach ($data->enderecos as $group_id)
                {
                    /*$system_wiki_share = new SystemWikiShareGroup;
                    $system_wiki_share->system_group_id = $group_id;
                    $system_wiki_share->system_wiki_page_id = $object->id_cliente;
                    $system_wiki_share->store();*/
                }
            }

            $object->unsetTags($object->id_cliente);

            if ($data->tags) 
            {
                foreach ($data->tags as $tag_value) 
                {
                    $tagCliente = new FuturoPrevidenciaTagCliente();
                    $tagCliente->id_tag = $tag_value;
                    $tagCliente->id_cliente = $object->id_cliente;
                    $tagCliente->store();
                }
            }

            $data->id_cliente = $object->id_cliente; 

            $this->form->setData($data);
            TTransaction::close();

            new TMessage('info', _t("Record saved"), new TAction(['FuturoPrevidenciaView', 'onReload']));

            TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            $this->form->setData( $this->form->getData() );
            TTransaction::rollback();
        }
    }
    
    /**
     * on edit
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key']; 
                TTransaction::open('futuro_previdencia');
                $object = new FuturoPrevidenciaClientes($key);
                $object->tags = $object->getTagsCliente($key);
                $object->enderecos = $object->getEnderecos($key);
                $this->form->setData($object);
                TTransaction::close();
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
}
