<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case PropertyManager = 'property_manager';
    case Accountant = 'accountant';
    case Agent = 'agent';
    case Owner = 'owner';
    case Tenant = 'tenant';
}
