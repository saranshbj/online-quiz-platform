@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Available Quizzes</h4>
                </div>
                <div id="messageContainer">
                </div>
                <div id="quizzesContainer">
                    <!-- quiz will display here -->
                </div>
            </div>
        </div>
    </div>

    {{-- script  --}}
    <script>
        $(document).ready(function() {

            // call fetchQuizzes
            fetchQuizzes();

            // fetch quizzes
            function fetchQuizzes() {
                $.ajax({
                    url: '{{ route('user.availableQuiz') }}',
                    method: 'GET',
                    success: function(response) {
                        displayQuizzes(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // display quizzes
            function displayQuizzes(quizzes) {
                var container = $('#quizzesContainer');
                container.empty();

                if (quizzes.length === 0) {
                    container.append('<p>No quizzes available.</p>');
                    return;
                }

                $.each(quizzes, function(index, quiz) {
                    var quizCard = `
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title fw-bold text-primary">${quiz.title}</h5>
                                    <p class="card-text">Marks Per Question : <span class="badge text-bg-primary">2</span></p>
                                </div>
                                <p class="card-text text-muted">${quiz.description}</p>
                                <p class="card-text"><strong>Number of Questions: <span class="badge text-bg-primary">${quiz.questions_count}</p>
                                <button  data-id="${quiz.id}" class="addQuestionButton btn btn-success">Take Quiz</button>
                            </div>
                        </div>
                        `;
                    container.prepend(quizCard);
                });
            }

            // Handle "Take Quiz" button click
            $('#quizzesContainer').on('click', '.addQuestionButton', function(event) {
                event.preventDefault();
                var quizId = $(this).data('id');

                window.location.href = '{{ route('user.takeQuiz', ':quizId') }}'.replace(':quizId', quizId);
            });
        });
    </script>
@endsection
