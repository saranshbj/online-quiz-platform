@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="fw-bold">Quiz Title : <span class="badge text-bg-primary">{{ $quizTitle }}</span></p>
                    <p class="fw-bold">Quiz Id : <span class="badge text-bg-primary">{{ $quizId }}</span></p>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Added Questions</h4>
                    <button id="openAddQuestionModalButton" class="btn btn-primary">Add Questions</button>
                </div>
                <div id="messageContainer">
                </div>
                <div id="questionContainer">
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    @include('profile.admin.partials.add-question-modal')
    <script>
        $(document).ready(function() {
            // get request to get all the questions
            function loadQuestionsAndAnswers(quizId) {
                $.ajax({
                    type: 'GET',
                    url: `{{ route('admin.getQuestion', '') }}/${quizId}`,
                    success: function(response) {
                        $('#questionContainer').empty();
                        var questionNumber = 1;

                        response.questionsAndAnswers.forEach(function(question) {
                            // Create a question card
                            var questionCard = `
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title fw-bold text-primary">Q ${questionNumber}: ${question.question_text}</h5>
                                    <div>
                                        <button type="button" class="delete-question btn btn-danger" data-question-id="${question.id}">Delete</button>
                                    </div>
                                </div>
                                <ul class="list-group">
                            `;
                            var answerLabels = ['A', 'B', 'C', 'D'];

                            // Loop through the answers for this question
                            question.answers.forEach(function(answer, index) {
                                var isCorrectClass = answer.is_correct ?
                                    'text-white bg-success' : '';

                                // Append answer to the question card with label
                                questionCard += `
                            <li class="list-group-item ${isCorrectClass}">
                                ${answerLabels[index]}. ${answer.answer_text}
                            </li>
                        `;
                            });

                            // Close the question card HTML
                            questionCard += `
                                </ul>
                            </div>
                        </div>
                    `;

                            // Append the question card to the container
                            $('#questionContainer').prepend(questionCard);

                            // Increment the question number
                            questionNumber++;
                        });
                    },
                    error: function(error) {
                        console.log('Error loading questions and answers: ' + error.responseText);
                    }
                });
            }

            // Initial load of questions and answers
            loadQuestionsAndAnswers('{{ $quizId }}');

            // modal open and clode
            $('#openAddQuestionModalButton').click(function() {
                $('#addQuestionModal').modal('show');
            });

            $('#addQuestionModal').on('hidden.bs.modal', function() {
                $('#addQuestionForm')[0].reset();
            });

            // Function to submit the form via AJAX
            $('#addQuestionForm').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.saveQuestion') }}',
                    data: formData,
                    success: function(response) {
                        loadQuestionsAndAnswers('{{ $quizId }}');
                        showMessage('Success: Question added successfully!', 'success');
                        setTimeout(clearMessages, 5000);
                        $('#addQuestionModal').modal('hide');

                    },
                    error: function(error) {
                        showMessage('Error: Something went wrong!', 'danger');
                        setTimeout(clearMessages, 5000);
                        console.log('Error saving question and answers: ' + error.responseText);
                    }
                });
            });

            // Add a click event listener to your delete button or icon
            $('#questionContainer').on('click', '.delete-question', function() {
                const questionId = $(this).data('question-id');

                // Confirm with the user before deleting
                if (confirm('Are you sure you want to delete this question?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: `{{ route('admin.deleteQuestion', '') }}/${questionId}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            loadQuestionsAndAnswers('{{ $quizId }}');
                            showMessage(response.message, 'success');
                            setTimeout(clearMessages, 5000);
                        },
                        error: function(error) {
                            showMessage('Error: Something went wrong!', 'danger');
                            setTimeout(clearMessages, 5000);
                            console.log('Error deleting question: ' + error.responseText);
                        }
                    });
                }
            });


        });
    </script>
@endsection
