<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Credenciales inválidas');
        }

        // Guardar sesión
        session()->set([
            'user_id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'], 
            'logged_in' => true
        ]);

        return redirect()->to('/compras'); // Redirige a tu panel principal
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
