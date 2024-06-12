<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1><?= $topic->getTitle() ?></h1>

<?php

    foreach($posts as $post ){ ?>
        <p><?= $post->getUser() ?> : <?= $post->getText() ?> (<?= $post->getCreationDate() ?>)</p>

<?php } ?>

<form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="POST">
    <textarea name="text" id="" required></textarea>
    <input type="submit" value="Post">
</form>