<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM papers WHERE status = 'approved' ORDER BY created_at DESC");
$papers = $stmt->fetchAll();
?>

<h1>Approved <span class="accent-text">Papers</span></h1>

<ul>
<?php foreach ($papers as $paper): ?>
    <li>
        <h3 class="paper-title"><?= htmlspecialchars($paper['title']) ?></h3>
        <p class="paper-meta">by <?= htmlspecialchars($paper['author_name']) ?> | <?= htmlspecialchars($paper['type']) ?> | <?= htmlspecialchars($paper['affiliation']) ?></p>
        <p class="paper-abstract"><?= htmlspecialchars(substr($paper['abstract'], 0, 200)) ?>...</p>
        <a href="<?= htmlspecialchars($paper['file_path']) ?>" class="paper-link" target="_blank">View Paper</a>
    </li>
<?php endforeach; ?>
</ul>

<?php include 'includes/footer.php'; ?>