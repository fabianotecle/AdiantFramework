<?php
/**
 * FuturoPrevidenciaTagCliente
 *
 * @version    1.0
 * @package    control
 * @subpackage FuturoPrevidenciaTagCliente
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaTagCliente extends TRecord
{
    const TABLENAME = 'tag_cliente';
    const PRIMARYKEY= 'id_tag_cliente';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $system_user;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id_tag');
        parent::addAttribute('id_cliente');
    }
}
