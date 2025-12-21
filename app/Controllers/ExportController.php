<?php

namespace App\Controllers;

use App\Models\ProductModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportController extends Controller
{
    public function __construct()
    {
        // Verificar autenticación
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }
    }

    public function exportProducts()
    {
        try {
            $productModel = new ProductModel();
            $products = $productModel
                ->select('products.id, products.name, products.price, products.image, categories.name as category')
                ->join('categories', 'categories.id = products.category_id')
                ->findAll();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Cabeceras
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Nombre');
            $sheet->setCellValue('C1', 'Precio');
            $sheet->setCellValue('D1', 'Categoría');
            $sheet->setCellValue('E1', 'Imagen');

            // Datos
            $row = 2;
            foreach ($products as $product) {
                $sheet->setCellValue('A' . $row, $product['id']);
                $sheet->setCellValue('B' . $row, $product['name']);
                $sheet->setCellValue('C' . $row, $product['price']);
                $sheet->setCellValue('D' . $row, $product['category']);
                $sheet->setCellValue('E' . $row, $product['image']);
                $row++;
            }

            // Generar archivo
            $writer = new Xlsx($spreadsheet);

            // Enviar archivo al navegador
            $filename = 'productos_' . date('Ymd_His') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al exportar productos');
        }
    }

    public function exportProductsPdf()
    {
        try {
            $productModel = new \App\Models\ProductModel();
            $products = $productModel
                ->select('products.id, products.name, products.price, products.image, categories.name as category')
                ->join('categories', 'categories.id = products.category_id')
                ->findAll();

            $html = view('export/pdf_products', ['products' => $products]);

            $options = new Options();
            $options->set('defaultFont', 'Arial');

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $dompdf->stream('productos_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al exportar PDF');
        }
    }
}
