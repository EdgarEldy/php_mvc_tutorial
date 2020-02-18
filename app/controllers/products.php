<?php
use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *
 */
class products extends controller
{

    /**
     */
    protected $categoryModel;
    protected $productModel;
    public function __construct()
    {
        $this->categoryModel=$this->model('category');
        $this->productModel=$this->model('product');
    }

    public function index()
    {
        // if (!isLoggedIn()) {
        //     redirect('users/login')  ;
        // }
        $products=$this->productModel->getProducts();
        $data= [
            'products' => $products
        ];
        return $this->render('products/index',$data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            $category = $this->categoryModel->getCategories();
            //Process form
            $data = [
                'category'=>$category,
                'fk_cat_id'=>trim($_POST['fk_cat_id']),
                'product_name' => trim($_POST['product_name']),
                'unit_price' => trim($_POST['unit_price']),
                'product_name_err' => '',
                'unit_price_err' => ''
            ];

            //Validate category id

            if (empty($data['fk_cat_id'])) {
                # code...
                $data['fk_cat_id_err'] = 'Please select the category';
            }

            // Validate product name
            if ( empty($data['product_name']) ) {
                $data['product_name_err'] = 'Please enter product name !';
            } else {
                // Check product name
                if ( $this->productModel->getProductByName($data['product_name']) ) {
                    $data['product_name_err'] = 'This product already exists !';
                }
            }
            
            //Validate unit price
            if (empty($data['unit_price'])) {
                # code...
                $data['unit_price_err'] = 'Please enter unit price !';

            }

            //Make sure errors are empty
            if ( empty($data['fk_cat_id_err']) && empty($data['product_name_err']) && empty($data['unit_price_err']) ) {

                if ( $this->productModel->add($data) ) {
                    redirect('products');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('products/add',$data);
            }

        }

        else
        {
            $categories=$this->categoryModel->getCategories();
            $data = [
                'categories'=>$categories,
                'fk_cat_id'=>'',
                'product_name' => '',
                'unit_price' => '',
                'fk_cat_id_err' => '',
                'product_name_err' => '',
                'unit_price_err' => ''
            ];
            $this->render('products/add',$data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $categories = $this->categoryModel->getCategories();

            $data=[
                'id' => $id,
                'categories'=>$categories,
                'fk_cat_id'=>trim($_POST['fk_cat_id']),
                'product_name'=>trim($_POST['product_name']),
                'unit_price'=>trim($_POST['unit_price']),
                'product_name_err'=>'',
                'unit_price_err'=>''
            ];

            //Validate category id

            if (empty($data['fk_cat_id'])) {
                # code...
                $data['fk_cat_id_err'] = 'Please select the category';
            }

            // Validate product name
            if ( empty($data['product_name']) ) {
                $data['product_name_err'] = 'Please enter product name !';
            } else {
                // Check product name
                if ( $this->productModel->getProductByName($data['product_name']) ) {
                    $data['product_name_err'] = 'This product already exists !';
                }
            }
            
            //Validate unit price
            if (empty($data['unit_price'])) {
                # code...
                $data['unit_price_err'] = 'Please enter unit price !';

            }

            if ( empty($data['fk_cat_id_err']) && empty($data['product_name_err']) && empty($data['unit_price_err']) ) {
                if ($this->productModel->update($data)) {
                    redirect('products');
                }
                else die('Something went wrong !');
            }
            else $this->render('products/edit',$data);

        }

        else
        {   
            $categories = $this->categoryModel->getCategories();
            $product=$this->productModel->getProductById($id);

            $data=[
                'id'=>$product->product_id,
                'categories'=>$categories,
                'fk_cat_id'=>$product->fk_cat_id,
                'product_name'=> $product->product_name,
                'unit_price'=> $product->unit_price,
                'fk_cat_id_err' => '',
                'product_name_err' => '',
                'unit_price_err' => ''
            ];
            $this->render('products/edit',$data);
        }
    }

    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->productModel->delete($id) ){
                redirect('products');
            } else {
                die('Something went wrong');
            }

        } else {
            redirect('products');
        }
    } //end function
}
