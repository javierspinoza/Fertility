<?php

namespace App\Http\Controllers;
use App\Models\Work;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;

use Illuminate\Http\Request;

class TrabajosPdfController extends Controller
{
    public function generarPDF(Request $request)
    {
        $request->validate(
            [
                'date_trabajo' => 'required|date',
            ],
            [
                'date_trabajo.required' => 'Este campo no puede estar vacio',
                'date_trabajo.date' => 'Selecciona una fecha.',
            ]
        );
        $fecha = $request->input('date_trabajo');

        $works = Work::whereDate('date_work', '=', $fecha)
        ->get();

        $html = View::make('PdfReportes.pdfTrabajosAgendados', compact('works'))->render();
        // $html = view('PdfReportes.pdfDemosAgendadas', compact('encuestas'))->render();

        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', TRUE);

        $dompdf->loadHtml($html);
        // Cambiar la orientación a horizontal y el tamaño de página a carta
        $dompdf->setPaper('letter', 'landscape');

        // Agregar el pie de página como una marca de agua en todas las páginas
        $watermark = '<div style="position: absolute; bottom: 0; left: 0; width: 100%; text-align: center; font-size: 12px; color: gray;">© Desarrollado por Javier Spinoza</div>';
        $canvas = $dompdf->get_canvas();
        $canvas->page_text(36, 780, $watermark, null, 0, array(128, 128, 128));

        $dompdf->render();

        // ABRIR EL PDF EN OTRA PESTAÑA, SE DEBE PONER ESTO EN EL FORM target="_blank" DE LA VISTA
        // Obtener el contenido del PDF como una cadena de bytes
        $output = $dompdf->output();

        // Establecer el encabezado de la respuesta para abrir el PDF en una nueva pestaña
        return response($output, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="trabajos-agendados-'.$fecha.'.pdf"');

        // DESCARGAR PDF DIRECTAMENTE, PERO ENTONCES QUITAR EN LA VISTA EN EL FORM ESTO target="_blank"
        // return $dompdf->stream('trabajos-agendados-'.$fecha.'.pdf');
    }
}
