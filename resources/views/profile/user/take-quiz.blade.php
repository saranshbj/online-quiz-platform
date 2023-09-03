@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('user.seeQuiz') }}"
                    class="btn btn-primary">Go Back</a>
                    <hr>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <p class="fw-bold">Quiz Title : <span class="badge text-bg-primary">{{ $quiz->title }}</span></p>
                        <p><strong>Quiz Description</strong> : {{ $quiz->description }}</p>
                    </div>
                    <p class="fw-bold">Quiz Id : <span class="badge text-bg-primary">{{ $quiz->id }}</span></p>
                </div>
                <form id="quizSubmissionForm" action="{{ route('user.takeQuiz', ['quizId' => $quiz->id]) }}" method="post" class="mb-4">
                    @csrf
                    <div id="questionContainer">
                        @foreach ($quiz->questions as $key => $question)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <p><strong>Q{{ $key + 1 }}</strong>: {{ $question->question_text }}</p>
                                    <hr>
                                    @foreach ($question->answers as $index => $answer)
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio"
                                                name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                                                id="answer{{ $answer->id }}">
                                            <label class="custom-control-label" for="answer{{ $answer->id }}">
                                                {{ chr(65 + $index) }}. {{ $answer->answer_text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Quiz</button>
                </form>
            </div>
        </div>
    </div>
@endsection
