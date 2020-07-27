<?php

use php_mvc_tutorial\app\libraries\connection\connection;

/**
 *
 * @author EDGARELDY
 *
 */
class user
{

    /**
     */
    private $db;
    public function __construct()
    {
        $this->db = new connection();
    }

    public function getUsers()
    {
        $this->db->query('SELECT profiles.id,profiles.profile_name,users.id,users.profile_id,users.first_name,
        users.last_name, users.email, users.username, DATE_FORMAT(users.created_at,"%d/%m/%Y") as created_at from profiles,users WHERE
		profiles.id=users.profile_id');
        return $this->db->resultSet();
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO user (fk_profile_id,username,pwd) values
          (:fk_profile_id, :username, :pwd)');
        // Bind values
        $this->db->bind(':fk_profile_id', $data['fk_profile_id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':pwd', $data['pwd']);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data)
    {
        $this->db->query('update user set fk_profile_id = :fk_profile_id, username=:username, pwd=:pwd where user_id=:user_id');
        $this->db->bind(':user_id', $data['id']);
        $this->db->bind(':fk_profile_id', $data['fk_profile_id']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':pwd', $data['pwd']);
        if ($this->db->execute()) {
            return TRUE;
        } else return false;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM user where user_id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $pwd)
    {
        $this->db->query('SELECT profile.profile_id,profile.profile_name,user.user_id,user.fk_profile_id,user.username,user.pwd
        from profile,user where profile.profile_id=user.fk_profile_id and user.username = :username');
        $this->db->bind(':username', $username);
        $row = $this->db->single();

        $hashed_pwd = $row->pwd;
        if (password_verify($pwd, $hashed_pwd)) {
            return $row;
        } else return FALSE;
    }

    public function checkPwd($email, $pwd)
    {
        $this->db->query('SELECT profile.profile_id,profile.profile_name,user.user_id,user.fk_profile_id,user.username,user.pwd
        from profile,user where profile.profile_id=user.fk_profile_id and user.email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        $hashed_pwd = $row->pwd;
        if (password_verify($pwd, $hashed_pwd))
            return $row;
        else return FALSE;
    }

    public function getUserByUsername($username)
    {
        $this->db->query('SELECT profile.profile_id,profile.profile_name,user.user_id,user.fk_profile_id,user.username,user.pwd
        from profile,user where profile.profile_id=user.fk_profile_id and user.username = :username');
        $this->db->bind(':username', $username);
        $this->db->single();
        if ($this->db->rowCount() > 0) {
            return TRUE;
        } else
            return FALSE;
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT profile.profile_id,profile.profile_name,user.user_id,user.fk_profile_id,user.username,user.pwd
        from profile,user where profile.profile_id=user.fk_profile_id and user.user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getUserByprofile($id)
    {
        $this->db->query('SELECT profile.profile_id,profile.profile_name,user.user_id,user.fk_profile_id,user.username,user.pwd
        from profile,user where profile.profile_id=user.fk_profile_id and user.user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
}
