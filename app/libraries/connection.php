<?php
/** 
 * @author EdgarEldy
 * 
 */
namespace php_mvc_tutorial\app\libraries\connection;
use PDO;
use PDOException;
class connection
{

    /**
     */
    private $dsn= 'mysql:host=localhost;dbname=simple_store_db';
    private $user= 'root';
    private $password= '';
    private $db;
    private $stmt;
    
    public function __construct()
    {
        
        try
        {
            return $this->db=new PDO($this->dsn,$this->user,$this->password,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_LOWER
                ));
        }
        
        catch(PDOException $e)
        {
            $msg ="Error in "  . $e->getFile() . "L" . $e->getLine() . ":" . $e->getMessage();
            die($msg);
        }
    }
    
    // Prepare statement query
    public function query($sql)
    {
        $this->stmt = $this->db->prepare($sql);
    }
    
    // Bind values
    public function bind($param, $value, $type = null)
    {
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    
    // Execute the prepared statement
    public function execute()
    {
        return $this->stmt->execute();
    }
    
    // Get result set as array of objects
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    // Get single record as object
    public function single(){
        $this->execute();
        return $this->stmt->fetch();
    }
    
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}

