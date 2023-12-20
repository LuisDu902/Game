<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'reason' => 'required|string',
            'explanation' => 'required|string',
            'question_id' => 'required|integer',
            // Add validation for other fields if needed
        ]);

        // Assuming 'reported_id' is the ID of the user being reported and needs to be included
        // You should add 'reported_id' to the form or handle it differently based on your application logic
        $question = Question::findOrFail($data['question_id']);

        // Set the reported_id to the user_id of the question
        $data['reported_id'] = $question->user_id;
        $data['date'] = now(); // Set current time
        $data['reporter_id'] = auth()->id(); // Set the ID of the reporter (logged-in user)
        $data['is_solved'] = false; // Default value for is_solved
        $data['report_type'] = 'Question_report'; // Assuming this is a report related to a question

        Report::create($data);

        return back()->with('success', 'Report submitted successfully.');
    }

    public function store2(Request $request)
    {
        $data = $request->validate([
            'reason' => 'required|string',
            'explanation' => 'required|string',
            'reported_id' => 'required|string',
            'answer_id' => 'required|string',
            // Add validation for other fields if needed
        ]);

        // Assuming 'reported_id' is the ID of the user being reported and needs to be included
        // You should add 'reported_id' to the form or handle it differently based on your application logic

        $data['date'] = now(); // Set current time
        $data['reporter_id'] = auth()->id(); // Set the ID of the reporter (logged-in user)
        $data['is_solved'] = false; // Default value for is_solved
        $data['report_type'] = 'Answer_report'; // Assuming this is a report related to a question

        Report::create($data);

        return back()->with('success', 'Report submitted successfully.');
    }

    public function store3(Request $request)
    {
        $data = $request->validate([
            'reason' => 'required|string',
            'explanation' => 'required|string',
            'reported_id' => 'required|string',
            'comment_id' => 'required|string',
            // Add validation for other fields if needed
        ]);

        // Assuming 'reported_id' is the ID of the user being reported and needs to be included
        // You should add 'reported_id' to the form or handle it differently based on your application logic

        $data['date'] = now(); // Set current time
        $data['reporter_id'] = auth()->id(); // Set the ID of the reporter (logged-in user)
        $data['is_solved'] = false; // Default value for is_solved
        $data['report_type'] = 'Comment_report'; // Assuming this is a report related to a question

        Report::create($data);

        return back()->with('success', 'Report submitted successfully.');
    }
}
