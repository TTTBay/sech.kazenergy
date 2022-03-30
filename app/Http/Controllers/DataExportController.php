<?php

namespace App\Http\Controllers;

use App\Exports\UniversityExport;
use App\Exports\CollegeExport;
use Maatwebsite\Excel\Facades\Excel;

class DataExportController extends Controller
{
    public function export($id)
    {
        switch ($id) {
            case '1':
                return Excel::download(new UniversityExport, 'university_teams.xlsx');
            case '2':
                return Excel::download(new CollegeExport, 'college_teams.xlsx');
            default:
                return false;
        }

    }
}
