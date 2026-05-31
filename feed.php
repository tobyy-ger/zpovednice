<?php
include "includes/db.php";
include "includes/header.php";

$sort = $_GET['sort'] ?? 'newest';

$order = match($sort){
    'oldest' => 'created_at ASC',
    'popular' => 'votes DESC',
    'unpopular' => 'votes ASC',
    default => 'created_at DESC'
};

$result = $conn->query("
    SELECT posts.*, 
    (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
    FROM posts
    ORDER BY $order
");
?>

    <div class="card">
        <form method="GET">
            <select name="sort" onchange="this.form.submit()">
                <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Nejnovější</option>
                <option value="oldest" <?= $sort == 'oldest' ? 'selected' : '' ?>>Nejstarší</option>
                <option value="popular" <?= $sort == 'popular' ? 'selected' : '' ?>>Nejoblíbenější</option>
                <option value="unpopular" <?= $sort == 'unpopular' ? 'selected' : '' ?>>Nejméně oblíbené</option>
            </select>
        </form>
    </div>

<?php while($post = $result->fetch_assoc()): ?>
    <div class="card">

        <div class="meta">
            Anonym | <?= $post['created_at'] ?>
        </div>

        <a href="post.php?id=<?= $post['id'] ?>" class="post-link">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
        </a>
        <br>
        <p>
            <?php
            if(strlen($post['content']) > 500){
                echo htmlspecialchars(substr($post['content'], 0, 500)) . " ... ";
                echo '<br><br><a href="post.php?id='.$post['id'].'" style="text-decoration: none; color: #eee;">Otevřít celý příspěvek</a>';
            } else {
                echo htmlspecialchars($post['content']);
            }
            ?>
        </p>
        <br>


        <div class="vote-buttons">
            <p>
            <?= $post['comment_count']?> odpovědi
            <a href="post.php?id=<?= $post['id'] ?>">💬 Otevřít diskuzi</a>
            </p><br>
            <p>
            <a href="vote.php?id=<?= $post['id'] ?>&type=up" style="font-size: 20px">⬆</a>
            <a  style="font-size: 20px; color: #eee;"><?= $post['votes'] ?></a>
            <a href="vote.php?id=<?= $post['id'] ?>&type=down" style="font-size: 20px">⬇</a>
            </p>
        </div>

    </div>
<?php endwhile; ?>

<?php include "includes/footer.php"; ?>
