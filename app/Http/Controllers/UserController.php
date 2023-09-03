<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizTaken;
use App\Models\UserAnswer;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function dashboard()
    {

        $user = auth()->user();
        $totalQuizzesAvailable = Quiz::whereDoesntHave('quizTaken', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $totalQuizzesTaken = QuizTaken::where('user_id', $user->id)->count();

        return view('profile.user.dashboard', compact('totalQuizzesAvailable', 'totalQuizzesTaken'));
    }

    public function seeQuiz()
    {
        return view('profile.user.quiz-available');
    }

    public function availableQuiz(Request $request)
    {
        $userId = $request->user()->id;

        $quizzes = Quiz::whereNotIn('id', function ($query) use ($userId) {
            $query->select('quiz_id')
                ->from('quiz_taken')
                ->where('user_id', $userId);
        })->withCount('questions')->get();

        return response()->json($quizzes);
    }

    public function takeQuiz(Request $request, $quizId)
    {
        $quiz = Quiz::with('questions.answers')->find($quizId);

        // Check if the quiz was not found
        if (!$quiz) {
            return redirect()->route('user.quizResult')->with('error', 'Quiz not found.');
        }

        if ($request->isMethod('post')) {
            // Define validation rules for submitted answers
            $validator = Validator::make($request->all(), [
                'answers' => 'required|array',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Calculate the score and save user answers
            $score = 0;
            $userAnswers = [];

            foreach ($quiz->questions as $question) {
                $selectedAnswerId = $request->input("answers.{$question->id}");
                $correctAnswer = $question->answers->where('is_correct', 1)->first();

                // Save user's answer to user_answers table
                $userAnswer = new UserAnswer([
                    'quiz_taken_id' => null, // We'll update this later
                    'question_id' => $question->id,
                    'answer_id' => $selectedAnswerId,
                ]);
                $userAnswers[] = $userAnswer;

                if ($selectedAnswerId == $correctAnswer->id) {
                    $score += 2; // Each correct answer earns 2 points
                }
            }

            // Save the quiz result to the database
            $user = auth()->user();
            $quizTaken = new QuizTaken([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
            ]);
            $quizTaken->save();

            // Update the quiz_taken_id in user_answers and save them
            foreach ($userAnswers as $userAnswer) {
                $userAnswer->quiz_taken_id = $quizTaken->id;
                $userAnswer->save();
            }

            // Redirect to the 'quizResult' route with a success message
            return redirect()->route('user.quizResult', ['quizId' => $quiz->id])->with('success', 'Quiz submitted successfully! Your score: ' . $score);
        }

        return view('profile.user.take-quiz', compact('quiz'));
    }

    public function quizResult()
    {
        $user = auth()->user();
        $quizResults = QuizTaken::where('user_id', $user->id)->with('quiz', 'userAnswers')->get();

        foreach ($quizResults as $quizResult) {
            $quizResult->questions_count = $quizResult->quiz->questions->count();
            $quizResult->correct_answers = $quizResult->userAnswers->filter(function ($userAnswer) {
                return $userAnswer->answer->is_correct;
            })->count();
            $quizResult->wrong_answers = $quizResult->questions_count - $quizResult->correct_answers;
        }

        // Filter out quiz results where the user hasn't taken the quiz
        $quizResults = $quizResults->filter(function ($quizResult) {
            return $quizResult->questions_count > 0;
        });

        return view('profile.user.quiz-results', compact('quizResults'));
    }

    public function viewAnswer($quizId)
    {
        $user = User::find(auth()->user()->id);
        $quiz = Quiz::with(['questions.answers', 'quizTaken.userAnswers'])->find($quizId);

        if (!$quiz) {
            return redirect()->route('user.quizResult')->with('error', 'Quiz not found.');
        }

        $userAnswers = $user->userAnswers()
            ->whereHas('quizTaken', function ($query) use ($quizId) {
                $query->where('quiz_id', $quizId);
            })->pluck('answer_id', 'question_id')->toArray();

        return view('profile.user.quiz-answers', compact('quiz', 'userAnswers'));
    }
}
