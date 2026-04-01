<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PpdbPrintController extends Controller
{
    public function __invoke()
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        $student = $user->student()->with('documents')->firstOrFail();

        $schoolName = Setting::get('school_name', 'SDN 001 Kepenuhan');

        // Generate QR code as SVG
        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(120)
                ->generate($student->registration_code)
        );

        $pdf = Pdf::loadView('ppdb.print', compact('student', 'schoolName', 'qrCode'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("Bukti_Pendaftaran_{$student->registration_code}.pdf");
    }
}
