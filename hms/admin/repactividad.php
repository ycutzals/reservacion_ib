<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hms');
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Crea una instancia de Dompdf
$dompdf = new Dompdf();

// Consulta los datos de la base de datos
$sql = "SELECT nomactividad, lugar, sociedad, UpdationDate FROM tblactividades";
$result = mysqli_query($con, $sql);

// Carga el contenido HTML

$html = '

<h1>REPORTE COMO TITULO</h1>
<table >
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;">Nombre Actividad</td>
            <td colspan="2" style="text-align:center;">Lugar</td>
            <td colspan="2" style="text-align:center;">Sociedad</td>
            <td colspan="2" style="text-align:center;">Fecha de Actualizacion</td>
        </tr>
    </thead>
    <tbody>';

// Recorre los resultados de la consulta y muestra los datos en HTML
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $html .= '
        <tr>
            <td colspan="2" style="text-align:center;">' . $row['nomactividad'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['lugar'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['sociedad'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['UpdationDate'] . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="10">No se encontraron registros.</td></tr>';
}

$html .= '
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align:center; font-weight: bold;">Reporte Administrador</td>
        </tr>
    </tfoot>
</table>';

// Renderiza el HTML en PDF
$dompdf->loadHtml($html);
$dompdf->render();

// Guarda el PDF en el servidor o descárgalo directamente
$output = $dompdf->output();
file_put_contents('C:\xampp\htdocs\guardar_pdf.pdf', $output);