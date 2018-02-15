<div class="editor-content" id="question-list-container">
    <h1>Question List</h1>
    
    <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'question-list')"><br>
    <ul class="question-list" id="quiz-question-list">
        <li><label for="Question 1"><input onclick="update_quiz_questions('quiz-question-list', 'quiz-questions-to-use')" type="checkbox" name="Question 1" value="Test Question 1">Test Question 1</label></li>
        <li><label for="Question 2"><input onclick="update_quiz_questions('quiz-question-list', 'quiz-questions-to-use')" type="checkbox" name="Question 2" value="Test Question 2">Test Question 2</label></li>
    </ul>
</div>