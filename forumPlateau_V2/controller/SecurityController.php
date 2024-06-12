<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Manager;
use App\Session;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {

        $userManager = new UserManager();

        if(isset($_POST["submit"])) {
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password1 = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if($pseudo && $email && $password1 && $password2){
                if($password1 == $password2 && strlen($password1 >= 6)) {
                    $userManager->add([
                        "pseudo" => $pseudo,
                        "email" => $email,
                        "password" => password_hash($password1, PASSWORD_DEFAULT)
                    ]);
                    $this->redirectTo("security", "login");
                }
            }
        }

        return [
            "view" => VIEW_DIR."security/register.php",
            "meta_description" => "Register page"
        ];
    }
    public function login () {

        $userManager = new UserManager();

        if(isset($_POST["submit"])) {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($email && $password){
                $user = $userManager->checkUserExists($email);

                if($user){
                    $hash = $user->getPassword();
                    if(password_verify($password, $hash)){
                        Session::setUser($user);
                        $this->redirectTo("forum", "index");
                    } else {
                        $this->redirectTo("security", "login");
                    }
                } else {
                    $this->redirectTo("security", "login");
                }
            }
            $this->redirectTo("security", "login");
        }
        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Log in page"
        ];
    }
    public function logout () {
        if(Session::getUser()) {
            Session::setUser(null);
            $this->redirectTo("security", "login");    
        }
    }
}