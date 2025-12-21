<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Category extends Controller
{
    public function index()
    {
        $model = new CategoryModel();
        $data['categories'] = $model->findAll();

        return view('category/index', $data);
    }

    public function create()
    {
        return view('category/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]|is_unique[categories.name]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new CategoryModel();
        try {
            $model->save([
                'name' => $this->request->getPost('name'),
            ]);
            return redirect()->to('/categories')->with('success', 'Categoría creada exitosamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al guardar categoría');
        }
    }

    public function edit($id)
    {
        $model = new CategoryModel();
        $data['category'] = $model->find($id);

        if (!$data['category']) {
            return redirect()->to('/categories')->with('error', 'Categoría no encontrada');
        }

        return view('category/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name' => "required|min_length[3]|is_unique[categories.name,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new CategoryModel();
        $category = $model->find($id);
        
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Categoría no encontrada');
        }

        try {
            $model->update($id, [
                'name' => $this->request->getPost('name'),
            ]);

            return redirect()->to('/categories')->with('success', 'Categoría actualizada correctamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la categoría');
        }
    }

    public function delete($id)
    {
        $model = new CategoryModel();
        $category = $model->find($id);
        
        if (!$category) {
            return redirect()->to('/categories')->with('error', 'Categoría no encontrada');
        }

        try {
            $model->delete($id);
            return redirect()->to('/categories')->with('success', 'Categoría eliminada');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al eliminar la categoría');
        }
    }
}
