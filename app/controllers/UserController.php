<?php
class UserController extends Controller
{
    
    public function index($params) {

        // $sous_programme = new SousProgramme();
        // $fillable = $sous_programme->fillable();
        // $attr = ['id', ...$fillable];

        $view = new CRUDView('crud');
        
        $view->render([
            "titrePage" => "Utilisateurs",
            "attributs" => User::attributs(),
            'entity' => User::class,
        ]);

    }
    
    public function login($params) {

        $view = new BlankView('login');
        
        $view->render([
            "title" => "eReserv | Page de connexion"
        ]);
    }

    
    public function log($params) {

        if(!isset($params)) $params = $_POST;
        extract($params);
        unset($_SESSION["echec"]);

        $user = User::whereAll([
            ["username", "=", $username],
            ["password", "=", sha1($password)]
        ])[0];

        $view = new PageView();

        if (!empty($user) && $user->getUsername()) {
            $_SESSION["username"]=$user->getUsername();
            $_SESSION["nom"]=$user->getNom();
            $_SESSION["role"]=$user->getRole();

            $view->redirect('dashboard');
        }
        else {
            $_SESSION["echec"]="echec";
            $view->redirect('login');
        }

    }

    public function logout() {

        $_SESSION = array();
        session_destroy();

        setcookie("users_login_tokken", "", time()-1, '/');
        setcookie("users_login_username", "", time()-1, '/');
        unset($_COOKIE["users_login_tokken"]);
        unset($_COOKIE["users_login_username"]);

        $view = new PageView();
        $view->redirect('home');

    }

}
