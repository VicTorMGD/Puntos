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

        // Generar token único para esta sesión
        $sessionToken = bin2hex(random_bytes(32));

        // Guardar el token en la base de datos (invalida cualquier sesión anterior)
        $userModel->update($user['id'], ['session_token' => $sessionToken]);

        // Guardar sesión con el token
        session()->set([
            'user_id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'session_token' => $sessionToken,
            'logged_in' => true
        ]);

        return redirect()->to('/compras');
    }

    public function logout()
    {
        // Limpiar el token de sesión en la base de datos
        $userId = session()->get('user_id');
        if ($userId) {
            $userModel = new UserModel();
            $userModel->update($userId, ['session_token' => null]);
        }

        // Limpiar todos los datos de sesión
        session()->remove(['user_id', 'name', 'email', 'role', 'session_token', 'logged_in']);

        // Destruir la sesión completamente
        session()->destroy();

        // Redirigir al login con headers anti-cache
        return redirect()->to('/login')
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setHeader('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
