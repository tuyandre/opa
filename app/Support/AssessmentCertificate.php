<?php

namespace App\Support;

use App\Models\AssessmentAttendant;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DompdfPdf;

class AssessmentCertificate
{
    public static function canIssue(AssessmentAttendant $attendant): bool
    {
        return $attendant->isSubmitted() && $attendant->passed === true;
    }

    public static function number(AssessmentAttendant $attendant): string
    {
        return 'OPA-C' . $attendant->assessment_id . '-' . str_pad((string) $attendant->id, 5, '0', STR_PAD_LEFT);
    }

    // House file naming standard: "YYMMDD Title.ext"
    public static function fileName(AssessmentAttendant $attendant): string
    {
        $name = trim(preg_replace('/\s+/', ' ', preg_replace('/[\\\\\/:*?"<>|]+/', ' ', $attendant->name)));

        return date('ymd') . ' Certificate ' . $name . '.pdf';
    }

    public static function make(AssessmentAttendant $attendant): DompdfPdf
    {
        $attendant->loadMissing('assessment');

        return Pdf::loadView('pdf.assessment_certificate', [
            'attendant' => $attendant,
            'assessment' => $attendant->assessment,
            'number' => self::number($attendant),
            'issue_date' => ($attendant->submitted_at ?? now())->format('F j, Y'),
        ])->setPaper('a4', 'landscape');
    }
}
