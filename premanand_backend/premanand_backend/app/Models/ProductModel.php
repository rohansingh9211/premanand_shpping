<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model {
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'product_name', 'description', 'price', 'image'];

    public function insert_product($data) {
        return $this->insert($data);
    }

    public function get_product($id) {
        return $this->where('id', $id)->first();
    }
}

