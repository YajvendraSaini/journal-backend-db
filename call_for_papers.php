<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_name = filter_input(INPUT_POST, 'author_name', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $designation = filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING);
    $affiliation = filter_input(INPUT_POST, 'affiliation', FILTER_SANITIZE_STRING);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $abstract = filter_input(INPUT_POST, 'abstract', FILTER_SANITIZE_STRING);

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["file"]["size"] > 500000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        $error = "Sorry, only PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO papers (author_name, type, designation, affiliation, title, abstract, file_path, user_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->execute([$author_name, $type, $designation, $affiliation, $title, $abstract, $target_file, $_SESSION['user_id']]);
            header("Location: index.php");
            exit();
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<h2>Call for Papers</h2>
<?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="author_name" required placeholder="Author Name">
    <select name="type" required>
        <option value="Faculty">Faculty</option>
        <option value="Research Scholar">Research Scholar</option>
    </select>
    <input type="text" name="designation" required placeholder="Designation">
    <input type="text" name="affiliation" required placeholder="Affiliation">
    <input type="text" name="title" required placeholder="Title">
    <textarea name="abstract" required placeholder="Abstract"></textarea>
    <input type="file" name="file" required>
    <button type="submit" class="button">Submit Paper</button>
</form>

<?php include 'includes/footer.php'; ?>