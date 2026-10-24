<?php

namespace App\Http\Controllers;

// Kelola akun customer (admin dan petugas)
class CustomerController extends PenggunaController
{
    protected string $role  = 'customer';
    protected string $label = 'Customer';
}
