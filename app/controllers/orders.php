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
        if(isset($_GET['cat_id'])){
            $cat_id = intval($_GET['cat_id']);
            $products = $this->productModel->getProductsByCatId($cat_id);
        $data = [
            'products' => $products
        ];
         $this->view('orders/getProducts', $data);
        }
        
    }

    public function getUnitPrice()
    {
        if(isset($_GET['product_id'])){
            $product_id = intval($_GET['product_id']);
            $product = $this->productModel->getUnitPriceByProductId($product_id);
            $data = [
                'unit_price' => $product->unit_price
            ];
            $this->view('orders/getUnitPrice', $data);
        }

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
                'customer_id'=>trim($_POST['customer_id']),
                'cat_id'=>trim($_POST['cat_id']),
                'product_id'=>trim($_POST['product_id']),
                'unit_price' => trim($_POST['unit_price']),
                'qty' => trim($_POST['qty']),
                'total' => trim($_POST['total']),
                'customer_id_err' => '',
                'cat_id_err' => '',
                'product_id_err' => '',
                'unit_price_err' => '',
                'qty_err' => '',
                'total_err' => ''
            ];
            
            // Validate customer id
            if (empty($data['customer_id'])) {
               $data['customer_id_err'] = 'Please select customer name' ;
            }

            // Validate category name
            if ( empty($data['cat_id']) ) {
                $data['cat_id_err'] = 'Please select category name !';
            }
            
            // Validate product name
            if ( empty($data['product_id']) ) {
                $data['product_id_err'] = 'Please select product name !';
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
            if ( empty($data['customer_id_err']) && empty($data['cat_id_err']) && empty($data['product_id_err']) && empty($data['unit_price_err']) 
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
                'customer_id'=> '',
                'cat_id'=>'',
                'product_id'=>'',
                'unit_price' => '',
                'qty' => '',
                'total' => '',
                'customer_id_err' => '',
                'cat_id_err' => '',
                'product_id_err' => '',
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
                'customer_id'=>trim($_POST['customer_id']),
                'cat_id'=>trim($_POST['cat_id']),
                'product_id'=>trim($_POST['product_id']),
                'unit_price' => trim($_POST['unit_price']),
                'qty' => trim($_POST['qty']),
                'total' => trim($_POST['total']),
                'customer_id_err' => '',
                'cat_id_err' => '',
                'product_id_err' => '',
                'unit_price_err' => '',
                'qty_err' => '',
                'total_err' => ''
            ];
            
            // Validate customer id
            if (empty($data['customer_id'])) {
               $data['customer_id_err'] = 'Please select customer name' ;
            }

            // Validate category name
            if ( empty($data['cat_id']) ) {
                $data['cat_id_err'] = 'Please select category name !';
            }
            
            // Validate product name
            if ( empty($data['product_id']) ) {
                $data['product_id_err'] = 'Please select product name !';
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
            if ( empty($data['customer_id_err']) && empty($data['cat_id_err']) && empty($data['product_id_err']) && empty($data['unit_price_err']) 
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
                'customer_id'=>'',
                'product_id'=>'',
                'cat_id'=>'',
                'unit_price' => $order->unit_price,
                'qty' => $order->qty,
                'total' => $order->total,
                'fk_customer_id_err' => '',
                'cat_id_err' => '',
                'product_id_err' => '',
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

