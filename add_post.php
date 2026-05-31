<?php
include "includes/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    header("Location: feed.php");
}
include "includes/header.php";
?>

    <div class="card">
        <h2>Přidat zpověď</h2>

        <form method="POST">
            <input type="text" name="title" placeholder="Nadpis" required>
            <textarea style="max-width: 100%; min-width: 100%; min-height: 200px" name="content" rows="8" placeholder="Napiš svou zpověď..." required></textarea>
            <button type="submit">Odeslat</button>
        </form>
    </div>

</div>
</main>
<?php include "includes/footer.php"; ?>
</div>
</body>
</html>