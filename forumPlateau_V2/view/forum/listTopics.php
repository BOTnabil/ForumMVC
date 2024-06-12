<?php
    use App\Session;

    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics'];
    $user = App\Session::getUser();
?>

<h1>Topics about "<?= $category->getName()  ?>"</h1>

<?php



foreach($topics as $topic ){ 
        $owner = $topic->getUser();
        $idTopic= $topic->getId(); ?>
        <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> by <?= $topic->getUser() ?> (<?= $topic->getCreationDate() ?>)</p>
        <?php
        if ($owner == $user or Session::isAdmin()) {
            echo "<a href='index.php?ctrl=forum&action=closeTopic&id=$idTopic'>Close Topic</a>";
        }
    } ?>

<form action="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" method="POST">
    <br><p>Create a new topic<p>
    <label>
        Title :
        <input type="text" name="title" id="" required></input><br>
    </label>
    <label>
        First post :
        <textarea name="text" id="" required></textarea><br>
    </label>
    <input type="submit" value="Create">
</form>
