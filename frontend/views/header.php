<div class="header">

    <div class="navbar">
        <div class="dropdown nav-item" id="editor-mode">
            <button class="dropbtn">Editor</button>
            
            <div class="dropdown-content">
                <a style="color: black; background-color: white;" href="../views/homepage_instructor.php">Question Editor</a>
                <a style="color: black; background-color: white;" href="../views/quiz_bank.php">Quiz Editor</a>
                <a style="color: black; background-color: white;" href="../views/view_grades.php">View Grades</a>
            </div>
        </div> 
        
        
        <a class="nav-item" id="current-page"><?php echo "Current view: " . $current_page?></a>
        <a href="https://web.njit.edu/~ar579/coolproject/" class="nav-item" id="logout">Logout</a>
    </div>
</div>