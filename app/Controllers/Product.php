<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['products'] = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->findAll();

        return view('product/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('product/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'permit_empty',
            'price'       => 'required|numeric|greater_than[0]',
            'category_id' => 'required|integer|is_not_unique[categories.id]',
            'image'       => 'permit_empty|uploaded[image]|is_image[image]|max_size[image,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $imageName = null;

        if ($image = $this->request->getFile('image')) {
            if ($image->isValid() && !$image->hasMoved()) {
                // Validar tipo MIME
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($image->getClientMimeType(), $allowedTypes)) {
                    return redirect()->back()->withInput()->with('error', 'Tipo de archivo no permitido. Solo se permiten imágenes.');
                }
                
                // Validar tamaño máximo (2MB)
                if ($image->getSize() > 2 * 1024 * 1024) {
                    return redirect()->back()->withInput()->with('error', 'La imagen es demasiado grande. Máximo 2MB.');
                }
                
                $imageName = $image->getRandomName();
                $image->move('uploads/', $imageName);
            }
        }

        try {
            $productModel = new ProductModel();
            $productModel->save([
                'name'        => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price'       => $this->request->getPost('price'),
                'category_id' => $this->request->getPost('category_id'),
                'image'       => $imageName,
            ]);

            return redirect()->to('/products')->with('success', 'Producto creado exitosamente');
        } catch (\Throwable $e) {
            // Eliminar imagen si se subió pero falló el guardado
            if ($imageName && file_exists('uploads/' . $imageName)) {
                unlink('uploads/' . $imageName);
            }
            return redirect()->back()->withInput()->with('error', 'Error al guardar el producto');
        }
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['product'] = $productModel->find($id);
        
        if (!$data['product']) {
            return redirect()->to('/products')->with('error', 'Producto no encontrado');
        }
        
        $data['categories'] = $categoryModel->findAll();

        return view('product/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'permit_empty',
            'price'       => 'required|numeric|greater_than[0]',
            'category_id' => 'required|integer|is_not_unique[categories.id]',
            'image'       => 'permit_empty|uploaded[image]|is_image[image]|max_size[image,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $productModel = new ProductModel();
        $product = $productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Producto no encontrado');
        }

        $imageName = $product['image']; // Conservar imagen actual

        if ($image = $this->request->getFile('image')) {
            if ($image->isValid() && !$image->hasMoved()) {
                // Validar tipo MIME
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($image->getClientMimeType(), $allowedTypes)) {
                    return redirect()->back()->withInput()->with('error', 'Tipo de archivo no permitido. Solo se permiten imágenes.');
                }
                
                // Validar tamaño máximo (2MB)
                if ($image->getSize() > 2 * 1024 * 1024) {
                    return redirect()->back()->withInput()->with('error', 'La imagen es demasiado grande. Máximo 2MB.');
                }
                
                // Eliminar imagen anterior si existe
                if ($imageName && file_exists('uploads/' . $imageName)) {
                    unlink('uploads/' . $imageName);
                }

                // Guardar nueva imagen
                $imageName = $image->getRandomName();
                $image->move('uploads/', $imageName);
            }
        }

        try {
            $productModel->update($id, [
                'name'        => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price'       => $this->request->getPost('price'),
                'category_id' => $this->request->getPost('category_id'),
                'image'       => $imageName,
            ]);

            return redirect()->to('/products')->with('success', 'Producto actualizado correctamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el producto');
        }
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Producto no encontrado');
        }

        try {
            // Eliminar imagen si existe
            if ($product['image'] && file_exists('uploads/' . $product['image'])) {
                unlink('uploads/' . $product['image']);
            }
            
            $productModel->delete($id);
            return redirect()->to('/products')->with('success', 'Producto eliminado');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al eliminar el producto');
        }
    }
}
