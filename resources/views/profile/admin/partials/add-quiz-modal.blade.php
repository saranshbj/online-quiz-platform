<div class="modal fade" id="addQuizModal" tabindex="-1" aria-labelledby="addQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuizModalLabel">Add Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addQuizForm">
                    @csrf
                    <div class="mb-3">
                        <label for="quizTitle" class="form-label">Quiz Title</label>
                        <input type="text" class="form-control" id="quizTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="quizDescription" name="description" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Quiz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
