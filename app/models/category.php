<?php

use php_mvc_tutorial\app\libraries\connection\connection;

/**
 *
 * @author EDGARELDY
 *
 */
class category
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
        $this->db->query('INSERT INTO categories(cat_name) VALUES ( :cat_name)');
        $this->db->bind('cat_name', $data['cat_name']);
        if ($this->db->execute()) {
          return TRUE  ;
        }
        else return FALSE;
    }

    public function update($data)
    {
        $this->db->query('UPDATE categories SET cat_name = :cat_name WHERE id=:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':cat_name', $data['cat_name']);
        if ($this->db->execute()) {
           return TRUE ;
        }
        else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM categories WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if( $this->db->execute() ){
            return true;
        } else {
            return false;
        }
    }

    public function getCategoryById($id)
    {
        $this->db->query('SELECT * FROM categories WHERE id =:id');
        $this->db->bind(':id', $id);
       return $this->db->single();
    }

    public function getCategories()
    {
        $this->db->query('SELECT * FROM categories');
        return $this->db->resultSet();
    }

    public function getCategoryByName($category)
    {
        $this->db->query('SELECT * FROM categories WHERE cat_name = :cat_name');
        $this->db->bind(':cat_name',$category);
        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return TRUE  ;
        }
        else
            return FALSE;
    }

    // Getting product category by product id
    public function getCatNameByProductId($id)
    {
        $this->db->query('SELECT categories.id, categories.cat_name AS category_name, products.id, products.cat_id AS category_id FROM categories, products 
        WHERE categories.id = products.cat_id AND products.id = :id ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
