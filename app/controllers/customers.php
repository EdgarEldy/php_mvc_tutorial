<?php

use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *        
 */
class customers extends controller
{

    /**
     */
    protected $customerModel;
    public function __construct()
    {
        $this->customerModel= $this->model('customer');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login') ;
        }
        $customers= $this->customerModel->getcustomers();
        $data=[
            'customers' => $customers
        ];
        $this->render('customers/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            //Process form
            $data = [
                'name' => trim($_POST['name']),
                'tel' => trim($_POST['tel']),
                'address' => trim($_POST['address'])
                'name_err' => '',
                'tel_err' => '',
                'address_err' => ''
            ];
            // Validate the name
            if ( empty($data['name']) ) {
                $data['name_err'] = 'Please enter name of the customer !';
            }
            
            // Validate tel
            if ( empty($data['tel']) ) {
                $data['tel_err'] = 'Please enter the mobile number !';
            }
            
            // Validate address
            if ( empty($data['address']) ) {
                $data['address_err'] = 'Please enter the address !';
            }
            
            //Make sure errors are empty
            if ( empty($data['name_err']) && empty($data['tel_err']) && empty($data['address_err']) ) {
                    if ( $this->customerModel->add($data) ) {
                        flash('register_success','You are now registered !');
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
            $data = [
                'name' => '',
                'tel' => '',
                'address' => '',
                'name_err' => '',
                'tel_err' => '',
                'address_err' => ''
            ];
            $this->render('customers/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $data=[
                'id' => $id,
                'name' => trim($_POST['name']),
                'tel' => trim($_POST['tel']),
                'address' => trim($_POST['address'])
                'name_err' => '',
                'tel_err' => '',
                'address_err' => ''
            ];
            
            // On valide le name
            if ( empty($data['name']) ) {
                $data['name_err'] = 'Veuillez entrer votre name !';
            }
            }
            
            // On valide le name d'utilisateur
            if ( empty($data['tel']) ) {
                $data['tel_err'] = 'Veuillez entrer votre numero de telephone !';
            }
            }
            
            // Validate address
            if ( empty($data['address']) ) {
                $data['address_err'] = 'Veuillez entrer l\'address !';
            }
            }
            
            //Make sure errors are empty
            if ( empty($data['name_err']) && empty($data['tel_err'])
                && empty($data['address_err']) ) {
                    if ( $this->customerModel->update($data) ) {
                        flash('register_success','You are now registered! You !');
                        redirect('customers/index');
                    } else {
                        die ('Something wrong');
                    }
                }
                else
                {
                    // Load view with errors
                    $this->render('customers/edit',$data);
                }
        }
        
        else
        {
            $customer=$this->customerModel->getcustomerById($id);
            $data = [
                'id'=>$customer->customer_id,
                'name' => $customer->name,
                'tel' => $customer->tel,
                'address' => $customer->address,
                'name_err' => '',
                'tel_err' => '',
                'address_err' => ''
            ];
            $this->render('customers/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->customerModel->delete($id) ){
                flash('Suppression reussi', 'customer removed');
                redirect('customers/index');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('customers/index');
        }
    }
}

