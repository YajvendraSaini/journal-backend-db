<?php
session_start();
include 'includes/header.php';
?>

<h1>Welcome to <span class="accent-text">Academic Paper Submission</span></h1>
<p>Explore cutting-edge research and submit your own papers to contribute to the academic community.</p>

<h2>Recent Papers</h2>
<ul>
    <li>
        <h3 class="paper-title">Example Paper Title</h3>
        <p class="paper-meta">by John Doe | Faculty | University of Example</p>
        <p class="paper-abstract">This is a brief abstract of the example paper...</p>
        <a href="#" class="paper-link">Read More</a>
    </li>
    <!-- Add more paper items as needed -->
</ul>

<?php include 'includes/footer.php'; ?>