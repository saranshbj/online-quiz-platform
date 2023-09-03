@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Quiz Results</h4>
                </div>
                <div id="messageContainer">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div id="quizResultsContainer">
                    @if ($quizResults->isEmpty())
                        <p>No quiz results available.</p>
                    @else
                        @foreach ($quizResults as $quizResult)
                            <div class="card mb-4 border border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-bold text-primary">{{ $quizResult->quiz->title }}</h5>
                                        <p class="card-text">Marks Per Question : <span
                                                class="badge text-bg-primary">2</span></p>
                                    </div>
                                    <p class="card-text text-muted"><strong>Description</strong> :
                                        {{ $quizResult->quiz->description }}</p>
                                    <p class="card-text"><strong>Number of Questions</strong> : <span
                                            class="badge text-bg-primary">{{ $quizResult->questions_count }}</span></p>
                                    <p class="card-text"><strong>Correct Answers</strong> : <span
                                            class="badge text-bg-success">{{ $quizResult->correct_answers }}</span></p>
                                    <p class="card-text"><strong>Wrong Answers</strong> : <span
                                            class="badge text-bg-danger">{{ $quizResult->wrong_answers }}</span></p>
                                    <hr>
                                    <p class="card-text"><strong>Total Score</strong> : <span
                                            class="badge text-bg-success">{{ $quizResult->score }}</span></p>
                                    <a href="{{ route('user.viewAnswer', ['quizId' => $quizResult->quiz->id]) }}"
                                        class="btn btn-success">View Result</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(clearMessages, 5000);
        });
    </script>
@endsection
