<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'reason' => 'required|string',
            'question_id' => 'required|integer',
            // Add validation for other fields if needed
        ]);

        // Assuming 'reported_id' is the ID of the user being reported and needs to be included
        // You should add 'reported_id' to the form or handle it differently based on your application logic

        $data['date'] = now(); // Set current time
        $data['reporter_id'] = auth()->id(); // Set the ID of the reporter (logged-in user)
        $data['reported_id'] = 1;
        $data['is_solved'] = false; // Default value for is_solved
        $data['report_type'] = 'Question_report'; // Assuming this is a report related to a question

        Report::create($data);

        return back()->with('success', 'Report submitted successfully.');
    }
}
