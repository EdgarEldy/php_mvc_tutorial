<?php

use php_mvc_tutorial\app\libraries\connection\connection;

/**
 *
 * @author EDGARELDY
 *
 */
class customer
{

    /**
     */
     private $db;
    public function __construct()
    {
      $this->db = new connection();
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO customer(name,tel,address) VALUES (:name , :tel, :address)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':tel', $data['tel']);
        $this->db->bind(':address', $data['address']);
        if ( $this->db->execute() ) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data)
    {
        $this->db->query('UPDATE customer set name = :name, tel = :tel, address = :address WHERE customer_id = :customer_id');
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':tel', $data['tel']);
        $this->db->bind(':address', $data['address']);
        if ($this->db->execute()) {
            return TRUE ;
        }
        else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM customer WHERE customer_id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if( $this->db->execute() ){
            return true;
        } else {
            return false;
        }
    }

    public function getCustomerById($id)
    {
        $this->db->query('SELECT * FROM customer WHERE customer_id =:id');
        $this->db->bind(':id', $id);
       return $this->db->single();
    }

    public function getCustomers()
    {
        $this->db->query('SELECT * FROM customer');
        return $this->db->resultSet();
    }

    public function getCustomerByName($customer)
    {
        $this->db->query('SELECT * FROM customer WHERE name = :name');
        $this->db->bind(':name',$customer);
        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return TRUE  ;
        }
        else
            return FALSE;
    }
}
