<?php

require_once 'classes/user-role.php';

abstract class User
{
    private int $id;
    const ROLE = UserRole::ABSTRACT;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
