<?php
/**
 * FuturoPrevidenciaClientes
 *
 * @version    1.0
 * @package    control
 * @author     Fabiano Alves
 * @copyright  Copyright (c) 2023 Futuro Previcência. (https://www.futuroprevidencia.com.br/)
 * @license    LGPD3
 */
class FuturoPrevidenciaClientes extends TRecord
{
    const TABLENAME = 'cliente';
    const PRIMARYKEY= 'id_cliente';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $system_user;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('celular');
        parent::addAttribute('email');
    }

    /**
     * List tags
     */
    public function getTags()
    {
        $tags = array();

        try
        {
            // valores personalizados
            TTransaction::open('futuro_previdencia'); // open transaction
            
            $conn = TTransaction::get();
            $query = $conn->query('SELECT id_tag, tag FROM tag');
            
            foreach($query as $i=>$r){
                $tags[$i] = new stdClass; 
                $tags[$i]->id_tag = $r['id_tag'];
                $tags[$i]->tag = $r['tag'];
            }

            TTransaction::close();
        }
        catch (Exception $mens)
        {
            new TMessage('error', $mens->getMessage());
        }
        
        return $tags;
    }

    /**
     * List tags
     */
    public function getTagsCliente($id_cliente)
    {
        $tags = array();

        try
        {
            // valores personalizados
            TTransaction::open('futuro_previdencia'); // open transaction
            
            $conn = TTransaction::get();
            $query = $conn->query('SELECT id_tag, tag FROM tag WHERE id_tag IN (SELECT id_tag FROM tag_cliente WHERE id_cliente = '. $id_cliente .')'); 

            foreach($query as $i=>$r){
                $tags[$i]->data['id_tag'] = $r->id_tag;
                $tags[$i]->data['tag'] = $r->tag;
            }

            TTransaction::close();
        }
        catch (Exception $mens)
        {
            new TMessage('error', $mens->getMessage());
        }

        echo '<pre>';
        print_r($tags);
        echo '</pre>';
        die;
        
        return $tags;
    }

    /**
     * List Addresses
     */
    public function getEnderecos($id_cliente=null)
    {
        $tags = array();

        try
        {
            // valores personalizados
            TTransaction::open('futuro_previdencia'); // open transaction
            
            $conn = TTransaction::get();
            $where = $id_cliente ? ' AND id_cliente = '. $id_cliente : '';
            $query = $conn->query('SELECT * FROM endereco WHERE 1 '. $where);
            
            foreach($query as $i=>$r){
                $tags[$i] = new stdClass;
                $tags[$i]->id_endereco = $r['id_endereco'];
                $tags[$i]->id_cliente = $r['id_cliente'];
                $tags[$i]->cep = $r['cep'];
                $tags[$i]->rua = $r['rua'];
                $tags[$i]->numero = $r['numero'];
                $tags[$i]->complemento = $r['complemento'];
                $tags[$i]->bairro = $r['bairro'];
                $tags[$i]->cidade = $r['cidade'];
                $tags[$i]->uf = $r['uf'];
            }

            TTransaction::close();
        }
        catch (Exception $mens)
        {
            new TMessage('error', $mens->getMessage());
        }
        
        return $tags;
    }

    public function getUFs() 
    {
        $ufs = array();

        try
        {
            // valores personalizados
            TTransaction::open('futuro_previdencia'); // open transaction
            
            $conn = TTransaction::get();
            $query = $conn->query('SELECT uf FROM endereco GROUP BY uf ORDER BY uf');
            
            foreach($query as $r){
                $ufs[] = $r->uf;
            }

            TTransaction::close();
        }
        catch (Exception $mens)
        {
            new TMessage('error', $mens->getMessage());
        } 
        
        return $ufs;
    }

    public function unsetEnderecos($id_cliente)
    {
        try
        {
            TTransaction::open('futuro_previdencia'); // open transaction
                
            $conn = TTransaction::get();
            $query = $conn->query('DELETE from endereco WHERE id_cliente = '. $id_cliente);

            TTransaction::close();
        }
        catch (Exception $mens)
        {
            new TMessage('error', $mens->getMessage());
        } 

        return true;
    }

    public function unsetTags($id_cliente)
    {
        try
        {
            TTransaction::open('futuro_previdencia'); // open transaction
                
            $conn = TTransaction::get();
            $query = $conn->query('DELETE from tag_cliente WHERE id_cliente = '. $id_cliente);

            TTransaction::close();
        }
        catch (Exception $mens)
        {
            new TMessage('error', $mens->getMessage());
        } 

        return true;
    }
}
