<?php
namespace controllers;

/**
 *
 * @author EDGARELDY
 *        
 */
class products
{

    /**
     */
    protected $modeleModel;
    protected $marqueModel;
    public function __construct()
    {
        $this->modeleModel=$this->model('modele');
        $this->marqueModel=$this->model('marque');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login')  ;
        }
        $modeles=$this->modeleModel->getModeles();
        $data= [
            'modeles' => $modeles
        ];
        return $this->render('modeles/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            $marque = $this->marqueModel->getMarques();
            //Process form
            $data = [
                'marque'=>$marque,
                'marque_id'=>trim($_POST['marque_id']),
                'nom_modele' => trim($_POST['nom_modele']),
                'nom_modele_err' => ''
            ];
            
            // Validate nom_modele
            if ( empty($data['nom_modele']) ) {
                $data['nom_modele_err'] = 'Veuillez entrer le modele de la marque de voiture !';
            } else {
                // Check nom_modele
                if ( $this->modeleModel->getModeleByName($data['nom_modele']) ) {
                    $data['nom_modele_err'] = 'Cet modele existe deja !';
                }
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_modele_err']) ) {
                
                if ( $this->modeleModel->add($data) ) {
                    flash('Enregistrement réussi','La marque de voiture a ete ajoutee !');
                    redirect('modeles/index');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('modeles/add',$data);
            }
            
        }
        
        else
        {
            $marque=$this->marqueModel->getMarques();
            $data = [
                'marque'=>$marque,
                'marque_id'=>'',
                'nom_modele' => '',
                'nom_modele_err' => ''
            ];
            $this->render('modeles/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $marque = $this->marqueModel->getMarques();
            
            $data=[
                'id' => $id,
                'marque'=>$marque,
                'marque_id'=>trim($_POST['marque_id']),
                'nom_modele'=>trim($_POST['nom_modele']),
                'nom_modele_err'=>''
            ];
            
            //Validation
            if (empty($data['nom_modele'])) {
                $data['nom_modele_err'] = 'Veuillez entrer la marque de la voiture !'  ;
            }
            
            if (empty($data['nom_modele_err'])) {
                if ($this->modeleModel->update($data)) {
                    flash('Mise a jour reussi', 'La marque a ete mis a jour ')  ;
                    redirect('modeles/index');
                }
                else die('Something went wrong !');
            }
            else $this->render('modeles/edit',$data);
            
        }
        
        else
        {
            $modele=$this->modeleModel->getModeleById($id);
            $marque = $this->marqueModel->getMarques();
            
            $data=[
                'id'=>$modele->id_modele,
                'marque'=>$marque,
                'marque_id'=>'',
                'nom_modele'=> $modele->nom_modele,
                'nom_modele_err'=>''
            ];
            $this->render('modeles/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->modeleModel->delete($id) ){
                flash('Suppression reussi', 'Post removed');
                redirect('modeles/index');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('modeles/index');
        }
    } //end function
}

