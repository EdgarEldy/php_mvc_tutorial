<?php

use php_mvc_tutorial\app\libraries\connection\connection;

/**
 *
 * @author EDGARELDY
 *
 */
class order
{

    /**
     */
    private $db;
    public function __construct()
    {
        $this->db = new connection();
    }

    public function getOrders()
    {
        $this->db->query('SELECT customers.id,customers.first_name, customers.last_name, products.id,products.product_name,products.unit_price,
            orders.id,orders.customer_id,orders.product_id,orders.qty,orders.total FROM
            customers,products,orders WHERE customers.id = orders.customer_id and products.id = orders.product_id ');
        return $this->db->resultSet();
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO orders (customer_id,product_id,qty,total) VALUES (:customer_id, :product_id, :qty, :total)');
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':total', $data['total']);
        if ($this->db->execute()) {
            return TRUE;
        } else return FALSE;
    }

    public function update($data)
    {
        $this->db->query('UPDATE `order` SET fk_customer_id = :fk_customer_id, fk_product_id = :fk_product_id, qty = :qty, total = :total WHERE order_id=:order_id');
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':fk_customer_id', $data['fk_customer_id']);
        $this->db->bind(':fk_product_id', $data['fk_product_id']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':total', $data['total']);
        if ($this->db->execute()) {
            return TRUE;
        } else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM `order` WHERE order_id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrderById($id)
    {
        $this->db->query('SELECT customer.customer_id,customer.name,product.product_id,product.product_name,product.unit_price,
            order.order_id,order.fk_customer_id,order.fk_product_id,order.qty,order.total FROM
            customer,product,`order` WHERE customer.customer_id = order.fk_customer_id and product.product_id = order.fk_product_id
            and order.order_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getOrdersByName($order)
    {
        $this->db->query('SELECT * FROM `order` WHERE order_name = :order_name');
        $this->db->bind(':order_name', $order);
        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return TRUE;
        } else
            return FALSE;
    }

    public function getOrdersByCustomerId()
    {
        if (isset($_GET['q'])) {
            $q = intval($_GET['q']);
            $this->db->query('SELECT customer.customer_id,customer.name,order.order_id,order.fk_customer_id,
          order.qty,order.total FROM customer,`order` WHERE customer.customer_id=order.fk_customer_id AND customer.customer_id=:q');
            $this->db->bind(':q', $q);
            return $this->db->resultSet();
        }
    }

    public function getTotalByQty()
    {
        if (isset($_GET['q'])) {
            $q = intval($_GET['q']);
            $this->db->query('SELECT * from `order` WHERE order.qty=:q');
            $this->db->bind(':q', $q);
            return $this->db->resultSet();
        }
    }
}
