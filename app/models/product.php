<?php

use php_mvc_tutorial\app\libraries\connection\connection;

/**
 *
 * @author EDGARELDY
 *
 */
class product
{

    /**
     */
    private $db;
    public function __construct()
    {
      $this->db=new connection();
    }

    public function add($data)
    {
        $this->db->query('insert into product(fk_cat_id,product_name,unit_price) values (:fk_cat_id, :product_name, :unit_price)');
        $this->db->bind('fk_cat_id', $data['fk_cat_id']);
        $this->db->bind('product_name', $data['product_name']);
        $this->db->bind('unit_price', $data['unit_price']);
        if ($this->db->execute()) {
          return TRUE  ;
        }
        else return FALSE;
    }

    public function update($data)
    {
        $this->db->query('update product set product_name = :product_name, unit_price = :unit_price WHERE product_id=:product_id');
        $this->db->bind(':product_id', $data['id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':unit_price', $data['unit_price']);
        if ($this->db->execute()) {
           return TRUE ;
        }
        else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM product WHERE product_id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if( $this->db->execute() ){
            return true;
        } else {
            return false;
        }
    }

    public function getProductById($id)
    {
        $this->db->query('SELECT * FROM product WHERE product_id =:id');
        $this->db->bind(':id', $id);
       return $this->db->single();
    }

    public function getProducts()
    {
        $this->db->query('Select * FROM product');
        return $this->db->resultSet();
    }

    public function getProductByName($product)
    {
        $this->db->query('SELECT * FROM product WHERE product_name = :product_name');
        $this->db->bind(':product_name',$product);
        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return TRUE  ;
        }
        else
            return FALSE;
    }

    public function getProductsByCatId()
 {
        if (isset($_GET['q'])) {
            $q=intval($_GET['q']);
         $this->db->query('SELECT category.cat_id,category.cat_name,product.product_id,product.fk_cat_id,
        product.product_name,product.unit_price FROM category,product WHERE category.cat_id=product.fk_cat_id AND category.cat_id=:q');
        $this->db->bind(':q', $q);
        return $this->db->resultSet();
        }

    }
}
