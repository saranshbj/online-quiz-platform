@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')
    <div class="container">
        <div class="row justify-content-center align-items-center custom-row-height">
            <div class="col-md-4">
                <a href="{{ route('user.seeQuiz') }}" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Quiz Available</h5>
                            <p class="card-text display-5">{{ $totalQuizzesAvailable }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('user.quizResult') }}" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Quiz Taken</h5>
                            <p class="card-text display-5">{{ $totalQuizzesTaken }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
