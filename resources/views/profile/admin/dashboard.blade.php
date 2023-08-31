@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <h1>Create New Quiz</h1>
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="title">Quiz Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="question-section">
                <h2>Questions</h2>
                <div class="question">
                    <input type="text" class="form-control" name="questions[]" placeholder="Enter question">
                    <label>Options:</label>
                    <input type="text" class="form-control" name="options[0][]" placeholder="Option 1">
                    <input type="text" class="form-control" name="options[0][]" placeholder="Option 2">
                </div>
            </div>

            <button type="button" class="btn btn-secondary" id="addQuestion">Add Question</button>
            <button type="submit" class="btn btn-primary">Create Quiz</button>
        </form>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addQuestionButton = document.getElementById('addQuestion');
            const questionSection = document.querySelector('.question-section');

            let questionCount = 1;

            addQuestionButton.addEventListener('click', function() {
                questionCount++;
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question';

                questionDiv.innerHTML = `
                        <input type="text" class="form-control" name="questions[]" placeholder="Enter question">
                        <label>Options:</label>
                        <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option 1">
                        <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option 2">
                    `;

                questionSection.appendChild(questionDiv);
            });
        });
    </script>
@endsection
