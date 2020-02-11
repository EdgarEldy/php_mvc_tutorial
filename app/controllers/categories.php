<?php
namespace controllers;

/**
 *
 * @author EDGARELDY
 *        
 */
class categories
{

    /**
     */
    protected $marqueModel;
    public function __construct()
    {
        $this->marqueModel=$this->model('marque');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login')  ;
        }
        $marques=$this->marqueModel->getMarques();
        $data= [
            'marques' => $marques
        ];
        return $this->render('marques/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            //Process form
            $data = [
                'nom_marque' => trim($_POST['nom_marque']),
                'nom_marque_err' => ''
            ];
            
            // Validate nom_marque
            if ( empty($data['nom_marque']) ) {
                $data['nom_marque_err'] = 'Veuillez entrer la marque de voiture !';
            } else {
                // Check nom_marque
                if ( $this->marqueModel->getMarqueByName($data['nom_marque']) ) {
                    $data['nom_marque_err'] = 'Cette marque existe deja !';
                }
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_marque_err']) ) {
                
                if ( $this->marqueModel->add($data) ) {
                    flash('marque_message','La marque de voiture a ete ajoutee avec succes !');
                    redirect('marques');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('marques/add',$data);
            }
            
        }
        
        else
        {
            $data = [
                'nom_marque' => '',
                'nom_marque_err' => ''
            ];
            $this->render('marques/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $data=[
                'id' => $id,
                'nom_marque'=>trim($_POST['nom_marque']),
                'nom_marque_err'=>''
            ];
            
            //Validation du nom de la marque
            if (empty($data['nom_marque'])) {
                $data['nom_marque_err'] = 'Veuillez entrer la marque de la voiture !'  ;
            }
            
            if (empty($data['nom_marque_err'])) {
                if ($this->marqueModel->update($data)) {
                    flash('marque_saved', 'La marque a ete mis a jour ')  ;
                    redirect('marques');
                }
                else die('Something went wrong !');
            }
            else $this->render('marques/edit',$data);
            
        }
        
        else
        {
            $marque=$this->marqueModel->getMarqueById($id);
            $data=[
                'id'=>$marque->id_marque,
                'nom_marque'=> $marque->nom_marque,
                'nom_marque_err'=>''
            ];
            $this->render('marques/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->marqueModel->delete($id) ){
                flash('delete_message', 'La marque a �t� suprim�e avec succes');
                redirect('marques');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('marques/index');
        }
    } //end function
}

