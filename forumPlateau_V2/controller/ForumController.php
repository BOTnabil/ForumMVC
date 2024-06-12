<?php
namespace Controller;

use App\Session;
use App\DAO;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;
use Model\Entities\User;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function listPostsByTopic($id) {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts dans : ".$topic,
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
        ];
    }

    public function addPost($id) {

        $postManager = new PostManager();
    
        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($text) {
            $postManager->add([
                "text"=> $text, 
                "topic_id" => $id, 
                "user_id" => Session::getUser()->getId()
            ]);
            $this->redirectTo("forum", "listPostsByTopic", $id);
        } else {
            $this->redirectTo("forum", "listPostsByTopic", $id);
        }
    }

    public function addTopic($id) {
        $postManager = new PostManager();
        $topicManager = new TopicManager();

        if(!empty($_POST["title"]) && !empty($_POST["text"])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if($title && $text) {
               $newId = $topicManager->add([
                    "title"=> $title, 
                    "category_id" => $id, 
                    "user_id" => Session::getUser()->getId()
                ]);
                $postManager->add([
                    "text"=> $text, 
                    "topic_id" => $newId, 
                    "user_id" => Session::getUser()->getId()
                ]);
                $this->redirectTo("forum", "listPostsByTopic", $newId);
            } 
        } else {
            $this->redirectTo("forum", "listTopicsByCategory", $id);
        }
    }

    public function closeTopic($id) {
        $topicManager = new TopicManager();
        $topicManager->deletePosts($id);
        $topicManager->closeTopic($id);
        $this->redirectTo("index");
    }
}