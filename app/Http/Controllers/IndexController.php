<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * Load main page of the application.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $schools = School::all();
        $countries = School::distinct()->pluck('country')->toArray();

        return view('index', ['schools' => $schools, 'countries' => $countries]);
    }

    /**
     * Search function.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSchools(Request $request)
    {
        $selectedSchoolId = $request->input('school');
        $selectedCountry = $request->input('country');

        $query = School::query();

        // conditions to search by school name or country
        if ($selectedSchoolId) {
            $query->where('id', $selectedSchoolId);
        }

        if ($selectedCountry) {
            $query->where('country', $selectedCountry);
        }

        $schools = $query->with('members')->get();

        return response()->json(['schools' => $schools]);
    }

    /**
     * Data feed for the bar chart.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function schoolMembersChartData()
    {
        $schools = School::withCount('members')->get();

        $schoolData = $schools->map(function ($school) {
            return [
                'name' => $school->name,
                'memberCount' => $school->members_count,
            ];
        });

        return response()->json(['schools' => $schoolData]);
    }

    /**
     * download CSV with all member/school data.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadCsv()
    {
        $members = Member::with('schools')->get();

        $filename = date('YmdHs') . '_members.csv';

        //CSV header
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // output stream
        $output = fopen('php://output', 'w');

        // Add CSV header row
        fputcsv($output, ['Name', 'Email', 'School']);

        // Add data to the CSV
        foreach ($members as $member) {
            foreach ($member->schools as $school) {
                fputcsv($output, [$member->name, $member->email, $school->name]);
            }
        }

        // Close output stream
        fclose($output);

        return Response::make(rtrim(ob_get_clean()), 200, $headers);
    }
}
