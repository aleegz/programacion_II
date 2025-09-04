<?php
namespace Models;

class User {
    public int $id;
    public string $email;
    public string $username;
    public string $password;

    public function __construct(int $id = null, string $email, string $username, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }
}
