@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')
    <div class="container">
        <div class="row justify-content-center align-items-center custom-row-height">
            <div class="col-md-4">
                <a href="{{ route('admin.quizzes') }}" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h4 class="card-title">Total Quiz Posted</h4>
                            <p class="card-text display-5">{{ $totalQuizzesPosted }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.userResult') }}" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h4 class="card-title">Total Results</h4>
                            <p class="card-text display-5">{{ $totalResults }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
