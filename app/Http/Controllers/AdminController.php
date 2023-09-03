<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuizTaken;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // ---- dashboard route controller method
    public function dashboard()
    {
        $totalQuizzesPosted = Quiz::count();
        $totalResults = QuizTaken::count();

        return view('profile.admin.dashboard', compact('totalQuizzesPosted', 'totalResults'));
    }

    public function addQuiz(Request $request)
    {
        if ($request->isMethod('post')) {
            // validate the data
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Create the quiz
            $quiz = new Quiz();
            $quiz->title = $request->input('title');
            $quiz->description = $request->input('description');
            $quiz->save();

            return response()->json(['message' => 'Quiz created successfully'], 201);
        }

        return view('profile.admin.added-quizzes');
    }

    // ---- get quiz
    public function getQuiz()
    {
        $quizzes = Quiz::withCount('questions')->get();
        return response()->json($quizzes);
    }

    public function deleteQuiz($quizId)
    {
        // find the quiz
        $quiz = Quiz::find($quizId);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $quiz->questions->each(function ($question) {
            $question->answers()->delete();
            $question->delete();
        });

        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted successfully']);
    }

    // ---- add question
    public function addQuestion($quizId)
    {
        $quiz = Quiz::find($quizId);

        if (!$quiz) {
            abort(404);
        }

        return view('profile.admin.add-question', [
            'quizId' => $quizId,
            'quizTitle' => $quiz->title,
        ]);
    }

    // ---- save question
    public function saveQuestion(Request $request)
    {
        // validate the data
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'answers' => 'required|array|min:4',
            'answers.*.answer_text' => 'required|string',
            'correct_answer_id' => 'required|integer|between:0,3',
        ]);

        // Use a database transaction for atomicity
        DB::beginTransaction();

        try {
            // create new question
            $question = new Question();
            $question->quiz_id = $request->input('quiz_id');
            $question->question_text = $request->input('question_text');
            $question->correct_answer_id = $request->input('correct_answer_id');
            $question->save();

            // create answers for the question
            foreach ($request->input('answers') as $key => $answerData) {
                $answer = new Answer();
                $answer->question_id = $question->id;
                $answer->answer_text = $answerData['answer_text'];
                $answer->is_correct = $key == $question->correct_answer_id;
                $answer->save();
            }

            DB::commit(); // Commit the transaction if everything is successful

            return response()->json(['message' => 'Question and answers saved successfully']);
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an error
            return response()->json(['error' => 'Error saving question and answers: ' . $e->getMessage()], 500);
        }
    }


    public function getQuestion($quizId)
    {
        $questionsAndAnswers = Quiz::find($quizId)->questions()->with('answers')->get();
        return response()->json(['questionsAndAnswers' => $questionsAndAnswers]);
    }

    public function deleteQuestion($questionId)
    {
        $question = Question::find($questionId);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }
        $question->answers()->delete();
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully']);
    }

    public function userResult()
    {
        $userResults = QuizTaken::with(['quiz', 'userAnswers.answer'])->get();

        // Initialize an array to store the calculated results
        $resultsArray = [];

        foreach ($userResults as $result) {
            $questionsCount = $result->quiz->questions->count();
            $correctAnswers = $result->userAnswers->where('answer.is_correct', true)->count();
            $wrongAnswers = $questionsCount - $correctAnswers;

            // Add the results to the array
            $resultsArray[] = [
                'userId' => $result->user->id,
                'user' => $result->user->name,
                'quizId' => $result->quiz->id,
                'quizTitle' => $result->quiz->title,
                'quizDescription' => $result->quiz->description,
                'questionsCount' => $questionsCount,
                'correctAnswers' => $correctAnswers,
                'wrongAnswers' => $wrongAnswers,
                'score' => $result->score,
            ];
        }

        return view('profile.admin.user-result', compact('resultsArray'));
    }

    public function userAnswer($quizId, $userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        // Find the quiz by ID with its questions and answers
        $quiz = Quiz::with(['questions.answers', 'quizTaken.userAnswers'])
            ->find($quizId);

        if (!$quiz) {
            return redirect()->route('user.quizResult')->with('error', 'Quiz not found.');
        }

        // Get the user's selected answers for this quiz
        $userAnswers = $user->userAnswers()
            ->whereHas('quizTaken', function ($query) use ($quizId) {
                $query->where('quiz_id', $quizId);
            })->pluck('answer_id', 'question_id')->toArray();

        // Return the view with the quiz and user answers
        return view('profile.admin.user-answer', compact('quiz', 'userAnswers'));
    }
}
