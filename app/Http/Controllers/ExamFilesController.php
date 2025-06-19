<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamFilesController extends Controller
{
    public function index(Request $request)
    {
        $apiUrl = "https://oeoaaluonpvxpyuvzmnl.supabase.co/rest/v1/main";
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9lb2FhbHVvbnB2eHB5dXZ6bW5sIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTAwMTg5MDIsImV4cCI6MjA2NTU5NDkwMn0.ctACY-w4c4koCTcHN5nbMeNONBTncTMVSYUg-jyW-Xw";

        $headers = [
            "apikey: $apiKey",
            "Authorization: Bearer $apiKey",
            "Accept: application/json",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        // Filters from URL
        $selectedYear = $request->query('year', '');
        $selectedSub = $request->query('sub', '');
        $searchQP = strtolower($request->query('qp', ''));

        // Filtered Data
        $filteredData = array_filter($data, function ($item) use ($selectedYear, $selectedSub, $searchQP) {
            $matchesYear = !$selectedYear || $item['Year'] == $selectedYear;
            $matchesSub = !$selectedSub || $item['Class/Subject'] == $selectedSub;
            $matchesQP = !$searchQP || strpos(strtolower(basename($item['QP'])), $searchQP) !== false;
            return $matchesYear && $matchesSub && $matchesQP;
        });

        $years = array_unique(array_column($data, 'Year'));
        sort($years);
        $subjects = array_unique(array_column($data, 'Class/Subject'));
        sort($subjects);

        return view('index', compact(
            'filteredData',
            'years',
            'subjects',
            'selectedYear',
            'selectedSub',
            'searchQP'
        ));
    }
    public function frosty(Request $request)
    {
        $apiUrl = "https://oeoaaluonpvxpyuvzmnl.supabase.co/rest/v1/main";
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9lb2FhbHVvbnB2eHB5dXZ6bW5sIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTAwMTg5MDIsImV4cCI6MjA2NTU5NDkwMn0.ctACY-w4c4koCTcHN5nbMeNONBTncTMVSYUg-jyW-Xw";

        $headers = [
            "apikey: $apiKey",
            "Authorization: Bearer $apiKey",
            "Accept: application/json",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        // Filters from URL
        $selectedYear = $request->query('year', '');
        $selectedSub = $request->query('sub', '');
        $searchQP = strtolower($request->query('qp', ''));

        // Filtered Data
        $filteredData = array_filter($data, function ($item) use ($selectedYear, $selectedSub, $searchQP) {
            $matchesYear = !$selectedYear || $item['Year'] == $selectedYear;
            $matchesSub = !$selectedSub || $item['Class/Subject'] == $selectedSub;
            $matchesQP = !$searchQP || strpos(strtolower(basename($item['QP'])), $searchQP) !== false;
            return $matchesYear && $matchesSub && $matchesQP;
        });

        $years = array_unique(array_column($data, 'Year'));
        sort($years);
        $subjects = array_unique(array_column($data, 'Class/Subject'));
        sort($subjects);

        return view('frosty', compact(
            'filteredData',
            'years',
            'subjects',
            'selectedYear',
            'selectedSub',
            'searchQP'
        ));
    }
}
