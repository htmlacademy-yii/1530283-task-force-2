<?php

require_once 'classes/user.php';
require_once 'classes/user-role.php';

class Customer extends User
{
    const ROLE = UserRole::CUSTOMER;
}
