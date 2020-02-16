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
    protected $customerModel;
    protected $productModel;
    public function __construct()
    {
        $this->customerModel=$this->model('customer');
        $this->productModel=$this->model('product');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login')  ;
        }
        $customers=$this->customerModel->getcustomers();
        $data= [
            'customers' => $customers
        ];
        return $this->render('orders/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            $product = $this->productModel->getproducts();
            //Process form
            $data = [
                'product'=>$product,
                'product_id'=>trim($_POST['product_id']),
                'nom_customer' => trim($_POST['nom_customer']),
                'nom_customer_err' => ''
            ];
            
            // Validate nom_customer
            if ( empty($data['nom_customer']) ) {
                $data['nom_customer_err'] = 'Veuillez entrer le customer de la product de voiture !';
            } else {
                // Check nom_customer
                if ( $this->customerModel->getcustomerByName($data['nom_customer']) ) {
                    $data['nom_customer_err'] = 'Cet customer existe deja !';
                }
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_customer_err']) ) {
                
                if ( $this->customerModel->add($data) ) {
                    flash('Enregistrement r�ussi','La product de voiture a ete ajoutee !');
                    redirect('customers/index');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('customers/add',$data);
            }
            
        }
        
        else
        {
            $product=$this->productModel->getproducts();
            $data = [
                'product'=>$product,
                'product_id'=>'',
                'nom_customer' => '',
                'nom_customer_err' => ''
            ];
            $this->render('customers/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $product = $this->productModel->getproducts();
            
            $data=[
                'id' => $id,
                'product'=>$product,
                'product_id'=>trim($_POST['product_id']),
                'nom_customer'=>trim($_POST['nom_customer']),
                'nom_customer_err'=>''
            ];
            
            //Validation
            if (empty($data['nom_customer'])) {
                $data['nom_customer_err'] = 'Veuillez entrer la product de la voiture !'  ;
            }
            
            if (empty($data['nom_customer_err'])) {
                if ($this->customerModel->update($data)) {
                    flash('Mise a jour reussi', 'La product a ete mis a jour ')  ;
                    redirect('customers/index');
                }
                else die('Something went wrong !');
            }
            else $this->render('customers/edit',$data);
            
        }
        
        else
        {
            $customer=$this->customerModel->getcustomerById($id);
            $product = $this->productModel->getproducts();
            
            $data=[
                'id'=>$customer->id_customer,
                'product'=>$product,
                'product_id'=>'',
                'nom_customer'=> $customer->nom_customer,
                'nom_customer_err'=>''
            ];
            $this->render('customers/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->customerModel->delete($id) ){
                flash('Suppression reussi', 'Post removed');
                redirect('customers/index');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('customers/index');
        }
    } //end function
}

