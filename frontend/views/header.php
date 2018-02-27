<div class="header">

    <div class="navbar">
        <div class="dropdown nav-item" id="editor-mode">
            <button class="dropbtn">Editor</button>
            
            <div class="dropdown-content">
                <a href="../views/homepage_instructor.php">Quenstion Editor</a>
                <a href="../views/exam_bank.php">Exam Editor</a>
                <a href="../views/view_grades.php">View Grades</a>
            </div>
        </div> 
        
        
        <a class="nav-item" id="current-page"><?php echo "Current view: " . $current_page?></a>
        <a class="nav-item" id="username">Username</a>
        <a href="#" class="nav-item" id="logout">Logout</a>
    </div>
</div>