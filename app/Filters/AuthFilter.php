<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Verificar si el usuario está autenticado
        if (!$session->get('user_id') || !$session->get('logged_in')) {
            $session->destroy();
            return redirect()->to('/login');
        }

        // Verificar que el token de sesión coincida con el de la BD
        // (esto invalida sesiones antiguas cuando el usuario inicia en otro dispositivo)
        $userId = $session->get('user_id');
        $sessionToken = $session->get('session_token');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        // Si el usuario no existe o el token no coincide, cerrar sesión
        if (!$user || $user['session_token'] !== $sessionToken) {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Tu sesión ha expirado porque iniciaste sesión en otro dispositivo.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Agregar headers anti-cache para evitar que el navegador muestre
        // páginas protegidas desde el cache al presionar "atrás"
        return $response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setHeader('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
