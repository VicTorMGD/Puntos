<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Datos del usuario autenticado
     *
     * @var array|null
     */
    protected $userData = null;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form', 'session'];


    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Cargar datos del usuario autenticado
        $this->loadUserData();
    }

    /**
     * Carga los datos completos del usuario autenticado
     * y los hace disponibles globalmente en las vistas
     */
    protected function loadUserData()
    {
        $session = session();

        if ($session->get('logged_in') && $session->get('user_id')) {
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            if ($user) {
                // Remover datos sensibles
                unset($user['password']);
                unset($user['session_token']);

                $this->userData = $user;

                // Hacer disponible en todas las vistas
                $renderer = service('renderer');
                $renderer->setVar('currentUser', $this->userData);
            }
        }
    }

    /**
     * Obtener datos del usuario actual
     */
    protected function getCurrentUser(): ?array
    {
        return $this->userData;
    }

    /**
     * Obtener URL del avatar del usuario
     */
    protected function getAvatarUrl(?string $avatar = null): string
    {
        if ($avatar && file_exists(WRITEPATH . 'uploads/avatars/' . $avatar)) {
            return base_url('uploads/avatars/' . $avatar);
        }

        // Avatar por defecto (iniciales)
        return '';
    }
}
