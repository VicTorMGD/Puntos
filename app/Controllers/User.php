<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{

    private function checkAuth()
    {
        // Verificar si el usuario está autenticado
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        // Verificar si el usuario es administrador
        if (session()->get('role') !== 'administrador') {
            session()->setFlashdata('error', 'Acceso no autorizado');
            return redirect()->to('/dashboard');
        }
    }

    public function index()
    {
        $this->checkAuth();
        
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('user/index', $data);
    }

    public function create()
    {
        $this->checkAuth();
        
        return view('user/create');
    }

    public function store()
    {
        $this->checkAuth();
        
        $validation = \Config\Services::validation();

        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[administrador,vendedor]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new \App\Models\UserModel();

        try {
            $userModel->save([
                'name'     => $this->request->getPost('name'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => $this->request->getPost('role'),
            ]);

            return redirect()->to('/users')->with('success', 'Usuario registrado exitosamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el usuario');
        }
    }
    
    public function edit($id)
    {
        $this->checkAuth();
        
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/users')->with('error', 'Usuario no encontrado');
        }

        return view('user/edit', $data);
    }

    public function update($id)
    {
        $this->checkAuth();
        
        $validation = \Config\Services::validation();

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'required|in_list[administrador,vendedor]',
        ];

        $input = $this->request->getPost();

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();

        $data = [
            'name'  => $input['name'],
            'email' => $input['email'],
            'role'  => $input['role'],
        ];

        // Solo cambiar contraseña si se envía
        if (!empty($input['password'])) {
            $data['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        }

        try {
            $userModel->update($id, $data);
            return redirect()->to('/users')->with('success', 'Usuario actualizado correctamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el usuario');
        }
    }

    public function delete($id)
    {
        $this->checkAuth();
        
        $userModel = new UserModel();

        if ($id == session('user_id')) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta');
        }

        try {
            $userModel->delete($id);
            return redirect()->to('/users')->with('success', 'Usuario eliminado');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al eliminar el usuario');
        }
    }
}
