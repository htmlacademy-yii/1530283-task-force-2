<?php

require_once 'classes/user.php';
require_once 'classes/user-role.php';

class Contractor extends User
{
    const ROLE = UserRole::CONTRACTOR;
}
