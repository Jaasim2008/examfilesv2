<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    public function aboutme()
    {
        $filename = storage_path('app/codes.csv');

        $rows = [];
        if (($handle = fopen($filename, "r")) !== false) {
            $headers = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = array_combine($headers, $data);
            }
            fclose($handle);
        }

        return view('aboutme', compact('rows'));
    }

}
