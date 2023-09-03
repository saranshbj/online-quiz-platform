@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Quiz Results</h4>
                </div>
                <div id="quizResultsContainer">
                    @if (empty($resultsArray))
                        <p>No quiz results available.</p>
                    @else
                        @foreach ($resultsArray as $result)
                            <div class="card mb-4 border border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title fw-bold">Quiz Taken By: <span
                                                class="text-primary">{{ $result['user'] }}</span></h3>
                                        <p class="card-text">Marks Per Question : <span
                                                class="badge text-bg-primary">2</span></p>
                                    </div>
                                    <hr>
                                    <h5 class="card-text"><strong>Quiz Title</strong> : {{ $result['quizTitle'] }}</h5>
                                    <p class="card-text"><strong>Description</strong> : {{ $result['quizDescription'] }}</p>
                                    <hr>
                                    <p class="card-text"><strong>Number of Questions</strong> : <span
                                            class="badge text-bg-primary">{{ $result['questionsCount'] }}</span></p>
                                    <p class="card-text"><strong>Correct Answers</strong> : <span
                                            class="badge text-bg-success">{{ $result['correctAnswers'] }}</span></p>
                                    <p class="card-text"><strong>Wrong Answers</strong> : <span
                                            class="badge text-bg-danger">{{ $result['wrongAnswers'] }}</span></p>
                                    <hr>
                                    <p class="card-text"><strong>Total Score</strong> : <span
                                            class="badge text-bg-success">{{ $result['score'] }}</span></p>
                                    <a href="{{ route('admin.userAnswer', ['quizId' => $result['quizId'], 'userId' => $result['userId']]) }}
                                        "
                                        class="btn btn-success">View Result</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
