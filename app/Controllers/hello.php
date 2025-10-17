<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Hello extends ResourceController
{
    public function test()
    {
    echo "hello ";
    }
}