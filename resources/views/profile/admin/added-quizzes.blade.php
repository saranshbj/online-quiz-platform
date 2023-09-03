@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Added Quizzes</h4>
                    <button id="openAddQuizModalButton" class="btn btn-primary">Add Quiz</button>
                </div>
                <div id="messageContainer">
                </div>
                <div id="quizzesContainer">
                    <!-- quiz will display here -->
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    @include('profile.admin.partials.add-quiz-modal')

    {{-- script  --}}
    <script>
        function openModal(modalSelector) {
            $(modalSelector).modal('show');
        }

        // clear modal form when modal is hidden
        function clearFormOnModalHidden(modalSelector, formSelector) {
            $(modalSelector).on('hidden.bs.modal', function() {
                $(formSelector)[0].reset();
            });
        }
        $(document).ready(function() {
            $('#openAddQuizModalButton').click(function() {
                openModal('#addQuizModal');
            });

            clearFormOnModalHidden('#addQuizModal', '#addQuizForm');

            // call fetchQuizzes
            fetchQuizzes();

            // fetch quizzes
            function fetchQuizzes() {
                $.ajax({
                    url: '{{ route('admin.getQuizzes') }}',
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
                                <button  data-id="${quiz.id}" class="addQuestionButton btn btn-success">Add Question</button>
                                <button data-id="${quiz.id}" class="deleteQuizButton btn btn-danger">Delete Quiz</button>
                            </div>
                        </div>
                        `;
                    container.prepend(quizCard);
                });
            }

            // add quiz form submission
            $('#addQuizForm').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                // ajax post request
                $.ajax({
                    url: '{{ route('admin.quizzes') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addQuizModal').modal('hide');

                        fetchQuizzes();
                        showMessage('Success: Quiz added successfully!', 'success');
                        setTimeout(clearMessages, 5000);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        showMessage('Error: Something went wrong!', 'danger');
                        setTimeout(clearMessages, 5000);
                    }
                });
            });

            //delete quiz
            $('#quizzesContainer').on('click', '.deleteQuizButton', function(event) {
                event.preventDefault();

                var quizId = $(this).data('id');
                var url = '{{ route('admin.deleteQuiz', ':id') }}';

                // ajax delete request
                $.ajax({
                    url: url.replace(':id', quizId),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        fetchQuizzes();
                        //succes message
                        showMessage('Success: Quiz Deleted successfully!', 'success');
                        setTimeout(clearMessages, 5000);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        //succes message
                        showMessage('Error: Something went wrong!', 'danger');
                        setTimeout(clearMessages, 5000);
                    }
                });
            });

            //question view
            $('#quizzesContainer').on('click', '.addQuestionButton', function(event) {
                event.preventDefault();

                var quizId = $(this).data('id');
                var url = '{{ route('admin.addQuestion', ':id') }}';

                // Redirect to the add-question page with the quizId
                window.location.href = url.replace(':id', quizId);
            });

        });
    </script>
@endsection
