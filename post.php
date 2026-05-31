<?php
include "includes/db.php";
include "includes/header.php";

$id = $_GET['id'];

$post = $conn->query("SELECT * FROM posts WHERE id=$id")->fetch_assoc();
$comments = $conn->query("SELECT * FROM comments WHERE post_id=$id ORDER BY created_at DESC");
?>

    <div class="card">
        <div class="meta">
            Anonym | <?= $post['created_at'] ?>
        </div>
        <h1><?= htmlspecialchars($post['title']) ?></h1><br>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p><br>

        <div class="vote-buttons">
            <a href="vote.php?id=<?= $post['id'] ?>&type=up">⬆</a>
            <a href="vote.php?id=<?= $post['id'] ?>&type=down">⬇</a>
            Votes: <?= $post['votes'] ?>
        </div>
    </div>

    <div class="card">
        <form action="add_comment.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $id ?>">
            <textarea name="content" required></textarea>
            <button>Přidat odpověď</button>
        </form>
    </div>

    <div class="card">
        <h2>Odpovědi</h2>

        <?php while($comment = $comments->fetch_assoc()): ?>
            <br>
            <div class="meta">
                Anonym | <?= $comment['created_at'] ?>
            </div>
            <p><?= htmlspecialchars($comment['content']) ?></p><br>
            <hr>
        <?php endwhile; ?>
    </div>

<?php include "includes/footer.php"; ?>
