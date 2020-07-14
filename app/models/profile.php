<?php

use php_mvc_tutorial\app\libraries\connection\connection;

/**
 *
 * @author EDGARELDY
 *
 */
class profile
{

    /**
     */
    private $db;
    public function __construct()
    {
        $this->db=new connection();
    }

    public function add($data)
    {
        $this->db->query('insert into profiles(profile_name) values ( :profile_name)');
        $this->db->bind('profile_name', $data['profile_name']);
        if ($this->db->execute()) {
            return TRUE  ;
        }
        else return FALSE;
    }

    public function update($data)
    {
        $this->db->query('update profiles set profile_name = :profile_name where id=:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':profile_name', $data['profile_name']);
        if ($this->db->execute()) {
            return TRUE ;
        }
        else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM profiles where id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if( $this->db->execute() ){
            return true;
        } else {
            return false;
        }
    }

    public function getProfiles()
    {
        $this->db->query('select * from profiles');
        return $this->db->resultSet();
    }

    public function getProfileById($id)
    {
        $this->db->query('select * from profiles where id =:id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getProfileByName($profil)
    {
        $this->db->query('select * from profiles where profile_name = :profile_name');
        $this->db->bind(':profile_name',$profil);
        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return TRUE  ;
        }
        else
            return FALSE;
    }
}
