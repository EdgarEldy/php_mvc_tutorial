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
        $this->customerModel = $this->model('customer');
    }

    public function index()
    {
        // if (!isLoggedIn()) {
        //     redirect('users/login') ;
        // }
        $customers = $this->customerModel->getcustomers();
        $data = [
            'customers' => $customers
        ];
        $this->render('customers/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Process form
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'tel' => trim($_POST['tel']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'first_name_err' => '',
                'last_name_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'address_err' => ''
            ];
            // Validate the name
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter your first name !';
            }

            // Validate the name
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter your last name !';
            }

            // Validate tel
            if (empty($data['tel'])) {
                $data['tel_err'] = 'Please enter your mobile number !';
            }

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email !';
            }

            // Validate address
            if (empty($data['address'])) {
                $data['address_err'] = 'Please your the address !';
            }

            //Make sure errors are empty
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['tel_err']) && empty($data['email_err']) && empty($data['address_err'])) {
                if ($this->customerModel->add($data)) {
                    flash('register_success', 'You are now registered !');
                    redirect('customers');
                } else {
                    die('Something wrong');
                }
            } else {
                // Load view with errors
                $this->render('customers/add', $data);
            }
        } else {
            $data = [
                'first_name' => '',
                'last_name' => '',
                'tel' => '',
                'email' => '',
                'address' => '',
                'first_name_err' => '',
                'last_name_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'address_err' => ''
            ];
            $this->render('customers/add', $data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Process form
            $data = [
                'id' => $id,
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'tel' => trim($_POST['tel']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'first_name_err' => '',
                'last_name_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'address_err' => ''
            ];

            // Validate the first name
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter your first name !';
            }

            // Validate the last name
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter your last name !';
            }

            // Validate tel
            if (empty($data['tel'])) {
                $data['tel_err'] = 'Please enter your mobile number !';
            }

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email address !';
            }

            // Validate address
            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter the address !';
            }
            //Make sure errors are empty
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['tel_err']) && empty($data['email_err']) && empty($data['address_err'])) {
                if ($this->customerModel->update($data)) {
                    redirect('customers');
                } else {
                    die('Something wrong');
                }
            } else {
                // Load view with errors
                $this->render('customers/edit', $data);
            }
        } else {
            $customer = $this->customerModel->getCustomerById($id);
            $data = [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'tel' => $customer->tel,
                'email' => $customer->email,
                'address' => $customer->address,
                'first_name_err' => '',
                'last_name_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'address_err' => ''
            ];
            $this->render('customers/edit', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->customerModel->delete($id)) {
                redirect('customers');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('customers');
        }
    }
}
