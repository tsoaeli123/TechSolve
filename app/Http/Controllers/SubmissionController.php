<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
   public function grade(Request $request, $testId, $studentId)
{
    $marks = $request->input('marks', []);
    $comments = $request->input('comments', []);

    foreach ($marks as $answerId => $mark) {
        $answer = Submission::find($answerId); // use the submission's id directly
        if (!$answer) continue;

        $answer->marks = $mark;
        $answer->comments = $comments[$answerId] ?? null;
        $answer->save();
    }

    if ($request->hasFile('marked_paper')) {
        $file = $request->file('marked_paper');
        $filename = 'marked_' . $studentId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/marked_papers', $filename);
        // Optional: save file path somewhere if needed
    }

    return redirect()->back()->with('success', 'Marks submitted successfully.');
}

}
