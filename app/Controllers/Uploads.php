<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Uploads extends Controller
{
    /**
     * Sirve archivos de avatars desde writable/uploads/avatars
     */
    public function avatar($filename)
    {
        $path = WRITEPATH . 'uploads/avatars/' . $filename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Obtener el tipo MIME
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($path);

        // Validar que sea una imagen
        $validMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mimeType, $validMimes)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Configurar headers de caché
        $lastModified = filemtime($path);

        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Length', filesize($path))
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setHeader('Last-Modified', gmdate('D, d M Y H:i:s', $lastModified) . ' GMT')
            ->setBody(file_get_contents($path));
    }
}
