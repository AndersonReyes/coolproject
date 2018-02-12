<div class="question-bank-container container">
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

    <div class="editor-content" id="question-list-container">
        <h1>Question List</h1>
        
        <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'question-list')"><br>
        <ul id="question-list">
            <li><a>Create a function that multiplies two numbers</a></li>
            <li><a>Create a function that adds two numbers</a></li>
            <li><a>Create a function that divides two numbers</a></li>
        </ul>
    </div>

</div>