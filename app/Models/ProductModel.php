<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'description', 'price', 'category_id', 'image'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    // Para relaciones (más adelante)
    protected $with = ['category'];
}
