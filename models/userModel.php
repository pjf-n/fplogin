<?php

class UserModel extends BaseModel {

    // Create table for users
    protected $table = 'users';

    // Define schema for users table
    protected $schema = array(
        'id',
        'username',
        'password',
        'email',
        'verified',
        'created_at',
        'verified_at',
    );

    public function login( $username, $password ) {

        // Select from the users table where user has a password and username set
        $statement = $this->db->prepare("select * from $this->table where username = :username and password = :password");
        $statement->execute(array(':username' => $username, ':password' => md5( $password ) ) );
        $row = $statement->fetch();

        return $row;
    }

    public function create( $data ) {

        // Hash the password
        $data['password'] = md5( $data['password'] );

        // Call the usual method
        return parent::create( $data );
    }
}
