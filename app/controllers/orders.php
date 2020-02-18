<?php
use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *        
 */
class orders extends controller
{

    /**
     */
    protected $customerModel,$categoryModel,$productModel,$orderModel;
    public function __construct()
    {
        $this->customerModel=$this->model('customer');
        $this->categoryModel=$this->model('category');
        $this->productModel=$this->model('product');
        $this->orderModel=$this->model('order');
    }
    
    public function index()
    {
        // if (!isLoggedIn()) {
        //     # code...
        //   redirect('users/login');
        // }
            $orders=$this->orderModel->getOrders();
            $data=[
                'orders' => $orders
            ];
            $this->render('orders/index',$data);
        
    }

    public function getProducts()
    {
        # code...
        $products = $this->productModel->getProductsByCatId();
        $data = [
            'products' => $products
        ];
        return $this->render('orders/getProducts', $data);
    }

    public function getUnitPrice()
        {
            $unit_price=$this->productModel->getUnitPriceByProductId();
            $data= [
                'unit_price' => $unit_price
            ];
            return $this->render('orders/getUnitPrice', $data);
        }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            $customers = $this->customerModel->getCustomers();
            $categories = $this->categoryModel->getCategories();
            $products = $this->productModel->getProducts();
            //Process form
            $data = [
                'customers'=>$customers,
                'categories'=>$categories,
                'products'=>$products,
                'fk_customer_id'=>trim($_POST['fk_customer_id']),
                'fk_cat_id'=>trim($_POST['fk_cat_id']),
                'fk_product_id'=>trim($_POST['fk_product_id']),
                'unit_price' => trim($_POST['unit_price']),
                'qty' => trim($_POST['qty']),
                'total' => trim($_POST['total']),
                'fk_customer_id_err' => '',
                'fk_cat_id_err' => '',
                'fk_product_id_err' => '',
                'unit_price_err' => '',
                'qty_err' => '',
                'total_err' => ''
            ];
            
            // Validate customer id
            if (empty($data['fk_customer_id'])) {
               $data['fk_customer_id_err'] = 'Please select customer name' ;
            }

            // Validate category name
            if ( empty($data['fk_cat_id']) ) {
                $data['fk_cat_id_err'] = 'Please select category name !';
            }
            
            // Validate product name
            if ( empty($data['fk_product_id']) ) {
                $data['fk_product_id_err'] = 'Please select product name !';
            }

            // Validate unit price
            if ( empty($data['unit_price']) ) {
                $data['unit_price_err'] = 'Please enter the unit price !';
            }

            // Validate qty
            if ( empty($data['qty']) ) {
                $data['qty_err'] = 'Please enter the qty !';
            }

            // Validate total
            if ( empty($data['total']) ) {
                $data['total_err'] = 'Please enter total !';
            }

            //Make sure errors are empty
            if ( empty($data['fk_customer_id_err']) && empty($data['fk_cat_id_err']) && empty($data['fk_product_id_err']) && empty($data['unit_price_err']) 
             && empty($data['qty_err']) && empty($data['total_err']) ) {
                
                if ( $this->orderModel->add($data) ) {
                    redirect('orders');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('orders/add',$data);
            }
            
        }
        
        else
        {
            $customers = $this->customerModel->getCustomers();
            $categories = $this->categoryModel->getCategories();
            $products = $this->productModel->getProducts();
            $data = [
                'customers'=>$customers,
                'categories'=>$categories,
                'products'=>$products,
                'fk_customer_id'=> '',
                'fk_cat_id'=>'',
                'fk_product_id'=>'',
                'unit_price' => '',
                'qty' => '',
                'total' => '',
                'fk_customer_id_err' => '',
                'fk_cat_id_err' => '',
                'fk_product_id_err' => '',
                'unit_price_err' => '',
                'qty_err' => '',
                'total_err' => ''
            ];
            $this->render('orders/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            $customers = $this->customerModel->getCustomers();
            $categories = $this->categoryModel->getCategories();
            $products = $this->productModel->getProducts();
            //Process form
            $data = [
                'customers'=>$customers,
                'categories'=>$categories,
                'products'=>$products,
                'fk_customer_id'=>trim($_POST['fk_customer_id']),
                'fk_cat_id'=>trim($_POST['fk_cat_id']),
                'fk_product_id'=>trim($_POST['fk_product_id']),
                'unit_price' => trim($_POST['unit_price']),
                'qty' => trim($_POST['qty']),
                'total' => trim($_POST['total']),
                'fk_customer_id_err' => '',
                'fk_cat_id_err' => '',
                'fk_product_id_err' => '',
                'unit_price_err' => '',
                'qty_err' => '',
                'total_err' => ''
            ];
            
            // Validate customer id
            if (empty($data['fk_customer_id'])) {
               $data['fk_customer_id_err'] = 'Please select customer name' ;
            }

            // Validate category name
            if ( empty($data['fk_cat_id']) ) {
                $data['fk_cat_id_err'] = 'Please select category name !';
            }
            
            // Validate product name
            if ( empty($data['fk_product_id']) ) {
                $data['fk_product_id_err'] = 'Please select product name !';
            }

            // Validate unit price
            if ( empty($data['unit_price']) ) {
                $data['unit_price_err'] = 'Please enter the unit price !';
            }

            // Validate qty
            if ( empty($data['qty']) ) {
                $data['qty_err'] = 'Please enter the qty !';
            }

            // Validate total
            if ( empty($data['total']) ) {
                $data['total_err'] = 'Please enter total !';
            }

            //Make sure errors are empty
            if ( empty($data['fk_customer_id_err']) && empty($data['fk_cat_id_err']) && empty($data['fk_product_id_err']) && empty($data['unit_price_err']) 
             && empty($data['qty_err']) && empty($data['total_err']) ) {
                if ($this->orderModel->update($data)) {
                    redirect('orders/index');

                }
                else die('Something went wrong !');
            }
            else $this->render('orders/edit',$data);
            
        }
        
        else
        {
            $customers = $this->customerModel->getCustomers();
            $categories = $this->categoryModel->getCategories();
            $products = $this->productModel->getProducts();
            $order = $this->orderModel->getOrderById($id);
            $data=[
                'id' => $order->order_id,
                'customers'=>$customers,
                'categories'=>$categories,
                'products'=>$products,
                'fk_customer_id'=>'',
                'fk_product_id'=>'',
                'fk_cat_id'=>'',
                'unit_price' => $order->unit_price,
                'qty' => $order->qty,
                'total' => $order->total,
                'fk_customer_id_err' => '',
                'fk_cat_id_err' => '',
                'fk_product_id_err' => '',
                'unit_price_err' => '',
                'qty_err' => '',
                'total_err' => ''
            ];
            $this->render('orders/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->orderModel->delete($id) ){
                flash('Suppression reussi', 'Post removed');
                redirect('orders');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('orders');
        }
    } //end function
}

