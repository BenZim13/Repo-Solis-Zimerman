<?php namespace App\Controllers;

use App\Models\UsuarioModelo; // Importar el modelo de Usuario

class FacturaController extends BaseController
{
    protected UsuarioModelo $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModelo();
    }

    /**
     * Muestra la factura de la última compra.
     * Los datos de la factura se obtienen de la sesión.
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $invoiceData = $this->session->get('last_invoice_data');

        if (empty($invoiceData)) {
            session()->setFlashdata('error', 'No se encontraron datos de la última factura.');
            return redirect()->to(base_url('catalogo')); // Redirigir al catálogo si no hay datos de factura
        }

        // Obtener datos del cliente usando el cliente_id guardado en la sesión
        $cliente = $this->usuarioModel->find($invoiceData['cliente_id']);

        if (!$cliente) {
            session()->setFlashdata('error', 'No se pudieron obtener los datos del cliente para la factura.');
            return redirect()->to(base_url('catalogo')); // Redirigir si no se encuentra el cliente
        }

        $data = [
            'titulo'    => 'Factura de Compra',
            'invoice'   => $invoiceData,
            'cliente'   => $cliente,
        ];

        // Una vez que se muestra la factura, eliminarla de la sesión para evitar que se muestre de nuevo
        $this->session->remove('last_invoice_data');

        return view('templates/factura', $data);
    }
}
