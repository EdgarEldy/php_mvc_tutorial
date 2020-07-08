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
        $this->db->query('insert into products(cat_id,product_name,unit_price) values (:cat_id, :product_name, :unit_price)');
        $this->db->bind('cat_id', $data['cat_id']);
        $this->db->bind('product_name', $data['product_name']);
        $this->db->bind('unit_price', $data['unit_price']);
        if ($this->db->execute()) {
          return TRUE  ;
        }
        else return FALSE;
    }

    public function update($data)
    {
        $this->db->query('UPDATE products SET cat_id = :cat_id, product_name = :product_name, unit_price = :unit_price WHERE id=:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':unit_price', $data['unit_price']);
        if ($this->db->execute()) {
           return TRUE ;
        }
        else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM products WHERE id = :id');
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
        $this->db->query('SELECT * FROM products WHERE id =:id');
        $this->db->bind(':id', $id);
       return $this->db->single();
    }

    public function getProducts()
    {
        $this->db->query('SELECT * FROM products');
        return $this->db->resultSet();
    }

    public function getProductByName($product)
    {
        $this->db->query('SELECT * FROM products WHERE product_name = :product_name');
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
         $this->db->query('SELECT categories.id,categories.cat_name,products.id,products.cat_id,
        products.product_name,products.unit_price FROM categories,products WHERE categories.id=products.cat_id AND categories.id=:q');
        $this->db->bind(':q', $q);
        return $this->db->resultSet();
        }

    }

    public function getUnitPriceByProductId()
    {
        # code...
        if (isset($_GET['q'])) {
            # code...
            $q = intval($_GET['q']);
            $this->db->query('SELECT categories.id,categories.cat_name,products.id,products.cat_id,
        products.product_name,products.unit_price FROM categories,products WHERE categories.id=products.cat_id AND products.id=:q');
            $this->db->bind(':q', $q);
            return $this->db->resultSet();
        }
    }
}
