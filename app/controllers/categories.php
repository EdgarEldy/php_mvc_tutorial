<?php
use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *
 */
class categories extends controller
{

    /**
     */
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel=$this->model('category');
    }

    //Call the view : categories/index
    public function index()
    {
        // if (!isLoggedIn()) {
        //     redirect('users/login')  ;
        // }
        $categories=$this->categoryModel->getCategories();
        $data= [
            'categories' => $categories
        ];
        return $this->render('categories/index',$data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            //Process form
            $data = [
                'cat_name' => trim($_POST['cat_name']),
                'cat_name_err' => ''
            ];

            // Validate cat_name
            if ( empty($data['cat_name']) ) {
                $data['cat_name_err'] = 'Please enter the name of the category !';
            } else {
                // Check cat_name
                if ( $this->categoryModel->getCategoryByName($data['cat_name']) ) {
                    $data['cat_name_err'] = 'This category already exists !';
                }
            }

            //Make sure errors are empty
            if ( empty($data['cat_name_err']) ) {

                if ( $this->categoryModel->add($data) ) {
                    redirect('categories');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('categories/add',$data);
            }

        }

        else
        {
            $data = [
                'cat_name' => '',
                'cat_name_err' => ''
            ];
            $this->render('categories/add',$data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $data=[
                'id' => $id,
                'cat_name'=>trim($_POST['cat_name']),
                'cat_name_err'=>''
            ];

            //Validate the category name
            if (empty($data['cat_name'])) {
                $data['cat_name_err'] = 'Please enter the name of the category !'  ;
            }

            if (empty($data['cat_name_err'])) {
                if ($this->categoryModel->update($data)) {
                    redirect('categories');
                }
                else die('Something went wrong !');
            }
            else $this->render('categories/edit',$data);

        }

        else
        {
            $category=$this->categoryModel->getCategoryById($id);
            $data=[
                'id'=>$category->id,
                'cat_name'=> $category->cat_name,
                'cat_name_err'=>''
            ];
            $this->render('categories/edit',$data);
        }
    }

    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->categoryModel->delete($id) ){
                flash('delete_message', 'Category has been removed');
                redirect('categories');
            } else {
                die('Something went wrong');
            }

        } else {
            redirect('categories/index');
        }
    } //end function
}
