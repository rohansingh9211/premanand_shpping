<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model {
    protected $table = 'banner';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'image'];

    public function insert_image($data) {
        return $this->insert($data);
    }

    public function get_image($id) {
        return $this->where('id', $id)->first();
    }
}

