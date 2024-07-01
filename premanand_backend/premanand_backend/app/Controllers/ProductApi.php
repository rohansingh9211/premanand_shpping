<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class BannerApi extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format = 'json';
}