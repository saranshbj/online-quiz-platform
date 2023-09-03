<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModalLabel">Add Questions to Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addQuestionForm">
                    @csrf
                    <!-- Include a hidden input for quiz_id -->
                    <input type="hidden" name="quiz_id" value="{{ $quizId }}">
                    <div class="mb-3">
                        <label for="questionText" class="form-label">Question</label>
                        <input type="text" class="form-control" id="questionText" name="question_text" required>
                    </div>
                    <div class="mb-3">
                        <label for="answer1" class="form-label">Answer 1</label>
                        <input type="text" class="form-control" id="answer1" name="answers[0][answer_text]" required>
                        <input type="radio" name="correct_answer_id" value="0"> Correct
                    </div>
                    <div class="mb-3">
                        <label for="answer2" class="form-label">Answer 2</label>
                        <input type="text" class="form-control" id="answer2" name="answers[1][answer_text]" required>
                        <input type="radio" name="correct_answer_id" value="1"> Correct
                    </div>
                    <div class="mb-3">
                        <label for="answer3" class="form-label">Answer 3</label>
                        <input type="text" class="form-control" id="answer3" name="answers[2][answer_text]" required>
                        <input type="radio" name="correct_answer_id" value="2"> Correct
                    </div>
                    <div class="mb-3">
                        <label for="answer4" class="form-label">Answer 4</label>
                        <input type="text" class="form-control" id="answer4" name="answers[3][answer_text]" required>
                        <input type="radio" name="correct_answer_id" value="3"> Correct
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
