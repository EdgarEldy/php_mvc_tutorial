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
        $this->db->query('INSERT INTO customers(first_name,last_name,tel,email,address) VALUES (:first_name, :last_name , :tel, :email, :address)');
        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':tel', $data['tel']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data)
    {
        $this->db->query('UPDATE customers set first_name = :first_name, last_name = :last_name, tel = :tel, address = :address WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':tel', $data['tel']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        if ($this->db->execute()) {
            return TRUE;
        } else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM customers WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomerById($id)
    {
        $this->db->query('SELECT * FROM customers WHERE id =:id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getCustomers()
    {
        $this->db->query('SELECT * FROM customers');
        return $this->db->resultSet();
    }

    public function getCustomerByName($customer)
    {
        $this->db->query('SELECT * FROM customers WHERE first_name = :first_name');
        $this->db->bind(':first_name', $customer);
        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return TRUE;
        } else
            return FALSE;
    }
}
