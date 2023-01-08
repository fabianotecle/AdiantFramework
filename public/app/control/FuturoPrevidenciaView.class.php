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
class FuturoPrevidenciaView extends TPage
{
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/system_welcome_pt.html');

        // replace the main section variables
        $html->enableSection('main', array());
        
        $panel = new TPanelGroup('Futuro Previdência - Clientes/Leads');
        $panel->add($html);
        
        $vbox = TVBox::pack($panel);
        $vbox->style = 'display:block; width: 100%';
        
        // add the template to the page
        parent::add( $vbox );
    }
}