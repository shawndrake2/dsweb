<?php

namespace DsWeb;

class AccountObject
{
    private $id;
    private $name;
    private $email1;
    private $email2;
    private $created;
    private $modified;
    private $status;
    private $privileges;

    public function __construct($data)
    {
        $this->id           = $data['id'];
        $this->name         = $data['name'];
        $this->email1       = $data['email1'];
        $this->email2       = $data['email2'];
        $this->created      = $data['created'];
        $this->modified     = $data['modified'];
        $this->status       = $data['status'];
        $this->privileges   = $data['privileges'] ?? null;
    }

    public function getID() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail1() { return $this->email1; }
    public function getEmail2() { return $this->email2; }
    public function getCreated() { return $this->created; }
    public function getModified() { return $this->modified; }
    public function getStatus() { return $this->status; }
    public function getPrivileges() { return $this->privileges; }
}
