<?php

namespace App\Controllers;

class CsrfController extends BaseController
{
    public function token()
    {
        return $this->response->setJSON([
            'csrf_token' => csrf_token(),
            'csrf_hash'  => csrf_hash()
        ]);
    }
}
