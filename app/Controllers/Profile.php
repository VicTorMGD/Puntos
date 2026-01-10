<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Muestra el formulario de perfil del usuario
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Usuario no encontrado');
        }

        return view('profile/index', [
            'title' => 'Mi Perfil',
            'user' => $user
        ]);
    }

    /**
     * Actualiza los datos del perfil
     */
    public function update()
    {
        $userId = session()->get('user_id');

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'phone' => 'permit_empty|max_length[20]'
        ];

        $messages = [
            'name' => [
                'required' => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder 100 caracteres'
            ],
            'email' => [
                'required' => 'El correo electrónico es obligatorio',
                'valid_email' => 'Ingrese un correo electrónico válido',
                'is_unique' => 'Este correo electrónico ya está registrado'
            ],
            'phone' => [
                'max_length' => 'El teléfono no puede exceder 20 caracteres'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        $this->userModel->update($userId, $data);

        // Actualizar nombre en la sesión
        session()->set('name', $data['name']);
        session()->set('email', $data['email']);

        return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Sube o actualiza el avatar del usuario
     */
    public function uploadAvatar()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $file = $this->request->getFile('avatar');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'No se ha seleccionado ninguna imagen válida');
        }

        // Validar tipo de archivo
        $validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $validTypes)) {
            return redirect()->back()->with('error', 'Solo se permiten imágenes (JPG, PNG, GIF, WEBP)');
        }

        // Validar tamaño (máximo 2MB)
        if ($file->getSize() > 2097152) {
            return redirect()->back()->with('error', 'La imagen no debe superar los 2MB');
        }

        // Eliminar avatar anterior si existe
        if ($user['avatar']) {
            $oldAvatarPath = WRITEPATH . 'uploads/avatars/' . $user['avatar'];
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        // Generar nombre único para el archivo
        $newName = 'avatar_' . $userId . '_' . time() . '.' . $file->getExtension();

        // Mover archivo a la carpeta de avatars
        $file->move(WRITEPATH . 'uploads/avatars', $newName);

        // Actualizar en base de datos
        $this->userModel->update($userId, ['avatar' => $newName]);

        return redirect()->to('/perfil')->with('success', 'Avatar actualizado correctamente');
    }

    /**
     * Elimina el avatar del usuario
     */
    public function deleteAvatar()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if ($user['avatar']) {
            $avatarPath = WRITEPATH . 'uploads/avatars/' . $user['avatar'];
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }

            $this->userModel->update($userId, ['avatar' => null]);
        }

        return redirect()->to('/perfil')->with('success', 'Avatar eliminado correctamente');
    }

    /**
     * Cambia la contraseña del usuario
     */
    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        $messages = [
            'current_password' => [
                'required' => 'La contraseña actual es obligatoria'
            ],
            'new_password' => [
                'required' => 'La nueva contraseña es obligatoria',
                'min_length' => 'La nueva contraseña debe tener al menos 6 caracteres'
            ],
            'confirm_password' => [
                'required' => 'Debe confirmar la nueva contraseña',
                'matches' => 'Las contraseñas no coinciden'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Verificar contraseña actual
        $currentPassword = $this->request->getPost('current_password');
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta');
        }

        // Actualizar contraseña
        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        $this->userModel->update($userId, ['password' => $newPassword]);

        return redirect()->to('/perfil')->with('success', 'Contraseña actualizada correctamente');
    }
}
