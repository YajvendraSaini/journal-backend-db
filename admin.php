<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

// Handle paper approval/rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paper_id = $_POST['paper_id'];
    $action = $_POST['action'];
    
    if ($action == 'approve') {
        $stmt = $pdo->prepare("UPDATE papers SET status = 'approved' WHERE id = ?");
    } elseif ($action == 'reject') {
        $stmt = $pdo->prepare("UPDATE papers SET status = 'rejected' WHERE id = ?");
    }
    
    if (isset($stmt)) {
        $stmt->execute([$paper_id]);
    }
}

// Fetch pending papers
$stmt = $pdo->query("SELECT * FROM papers WHERE status = 'pending' ORDER BY created_at DESC");
$pending_papers = $stmt->fetchAll();
?>

<h1>Admin Panel - <span class="accent-text">Pending Papers</span></h1>

<?php if (empty($pending_papers)): ?>
    <p>No pending papers at the moment.</p>
<?php else: ?>
    <ul class="paper-list">
    <?php foreach ($pending_papers as $paper): ?>
        <li>
            <h3 class="paper-title"><?= htmlspecialchars($paper['title']) ?></h3>
            <p class="paper-meta">by <?= htmlspecialchars($paper['author_name']) ?> | <?= htmlspecialchars($paper['type']) ?> | <?= htmlspecialchars($paper['affiliation']) ?></p>
            <p class="paper-abstract"><?= htmlspecialchars(substr($paper['abstract'], 0, 200)) ?>...</p>
            <a href="<?= htmlspecialchars($paper['file_path']) ?>" class="paper-link" target="_blank">View Full Paper</a>
            <form method="POST" class="approval-form">
                <input type="hidden" name="paper_id" value="<?= $paper['id'] ?>">
                <button type="submit" name="action" value="approve" class="button approve">Approve</button>
                <button type="submit" name="action" value="reject" class="button reject">Reject</button>
            </form>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>