<?php
/**
 * FuturoPrevidenciaTagsForm
 *
 * @version    1.0
 * @package    control
 * @subpackage FuturoPrevidenciaView
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaTagsForm extends TPage
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

        $this->form = new BootstrapFormBuilder('tags_form');
        $this->form->setFormTitle('Tags');

        $id = new THidden('id_tag');
        $tag = new TEntry('tag');

        $tag->addValidation("Tag", new TRequiredValidator()); 

        $tag->setSize('100%');
        
        $this->form->addFields([$id]);
        $row = $this->form->addFields([new TLabel("Tag" . ':', '#ff0000', '14px', null, '100%'),$tag]);
        $row->layout = ['col-sm-12'];
        
        $btn_onsave = $this->form->addAction(_t("Save"), new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 
        $btn_onshow = $this->form->addAction(_t("Back"), new TAction(['FuturoPrevidenciaTagsView', 'onReload']), 'fas:arrow-left #000000');
        
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
            $object = new FuturoPrevidenciaTag;
            $data = $this->form->getData();
            
            $object->fromArray( (array) $data);
            $object->store();

            $data->id = $object->id; 

            $this->form->setData($data);
            TTransaction::close();

            new TMessage('info', _t("Record saved"), new TAction(['FuturoPrevidenciaTagsView', 'onReload']));

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
                $object = new FuturoPrevidenciaTag($key);
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
