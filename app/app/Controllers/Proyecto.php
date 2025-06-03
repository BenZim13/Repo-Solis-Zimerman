<?php
namespace App\Controllers;
class Proyecto extends BaseController
{
    public function quienesSomos()
    {
        // Redirige a la sección específica de la vista principal
        return redirect()->to(base_url('#quienes-somos'));
    }
}
?>