<div class="editor-content" id="question-editor">
    <h1>Question Editor</h1>
    <input type="text" class="text-input" id="question-name-input" placeholder="Enter question name" id="question-name-input"><br>

    <textarea class="textarea-input" placeholder="Enter Question here" id="question-description"></textarea><br>

    <textarea class="textarea-input" placeholder="Enter code to test correctness of question here" id="question-testcorrectness-area"></textarea><br>

    <div class="horizontal-btn-group">
        <!-- TODO: Create a difficulty dropdown here with medium, easy, hard -->
        <div id="difficulty-rank">
            <select>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
        </div>

        <input type="number" placeholder="Points" style="width: 55px">
        <input type="text" placeholder="Question Tags">
    </div><br>

    <div class="horizontal-btn-group">
        <button>Create</button>
        <button>Reset</button>
    </div>
</div>