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
$sql = "SELECT specilization, doctorName, contactno, docEmail, creationDate FROM doctors";
$result = mysqli_query($con, $sql);

// Carga el contenido HTML

$html = '

<Center><h1>REPORTE DE CONSEJEROS</Center>
<table>
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;">Especializacion</td>
            <td colspan="2" style="text-align:center;">Nombre del Consejero</td>
            <td colspan="2" style="text-align:center;">Telefono</td>
            <td colspan="2" style="text-align:center;">Correo electronico</td>
            <td colspan="2" style="text-align:center;">Fecha de Creacion</td>
        </tr>
    </thead>
    <tbody>';

// Recorre los resultados de la consulta y muestra los datos en HTML
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $html .= '
        <tr>
            <td colspan="2" style="text-align:center;">' . $row['specilization'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['doctorName'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['contactno'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['docEmail'] . '</td>
            <td colspan="2" style="text-align:center;">' . $row['creationDate'] . '</td>
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