@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('user.seeQuiz') }}" class="btn btn-primary">Go Back</a>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <p class="fw-bold">Quiz Title : <span class="badge text-bg-primary">{{ $quiz->title }}</span></p>
                        <p><strong>Quiz Description</strong> : {{ $quiz->description }}</p>
                    </div>
                    <p class="fw-bold">Quiz Id : <span class="badge text-bg-primary">{{ $quiz->id }}</span></p>
                </div>
                <div id="questionContainer">
                    @foreach ($quiz->questions as $key => $question)
                        <div class="card mb-4">
                            <div class="card-body">
                                <p><strong>Q{{ $key + 1 }}</strong>: {{ $question->question_text }}</p>
                                <hr>
                                @foreach ($question->answers as $index => $answer)
                                    <div class="custom-control custom-radio">
                                        @php
                                            $userSelectedAnswer = $userAnswers[$question->id] ?? null;
                                            $isCorrectAnswer = $answer->is_correct;
                                        @endphp
                                        <div
                                            style="
                                            @if ($userSelectedAnswer == $answer->id) @if ($isCorrectAnswer)
                                                background-color:green;
                                                color: white;
                                                @else
                                                background-color:red;
                                                color: white; @endif
                                            @else
                                            transparent
                                            @endif">
                                            {{ chr(65 + $index) }}. {{ $answer->answer_text }}
                                            @if ($isCorrectAnswer)
                                                @if ($userSelectedAnswer != $answer->id)
                                                    <span class="badge bg-success">Correct</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
