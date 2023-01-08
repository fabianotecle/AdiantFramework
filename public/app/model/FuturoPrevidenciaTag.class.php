<?php
/**
 * FuturoPrevidenciaTag
 *
 * @version    1.0
 * @package    control
 * @subpackage FuturoPrevidenciaView
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaTag extends TRecord
{
    const TABLENAME = 'tag';
    const PRIMARYKEY= 'id_tag';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $system_user;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tag');
    }
}
