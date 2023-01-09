<?php
/**
 * FuturoPrevidenciaEndereco
 *
 * @version    1.0
 * @package    control
 * @subpackage FuturoPrevidenciaEnderecoCliente
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaEndereco extends TRecord
{
    const TABLENAME = 'endereco';
    const PRIMARYKEY= 'id_endereco';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $system_user;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id_endereco');
        parent::addAttribute('id_cliente');
        parent::addAttribute('cep');
        parent::addAttribute('rua');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cidade');
        parent::addAttribute('uf');
    }
}
