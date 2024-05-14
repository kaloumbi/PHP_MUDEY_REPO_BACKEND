<?php

namespace Model;

use DateTime;
use entity\Category;
use entity\Comment;
use entity\Review;
use entity\User;
use entity\Video;
use PDO;

class Repository
{
    private $connexion;

    function __construct()
    {
        try {
            //code...
            $dns = "mysql:host=" . DB_HOST . ";db_name" . DB_NAME;
            $this->connexion = new PDO($dns, DB_USER, DB_PASSWORD);

            //echo "Connexion réussie !!!";
        } catch (\PDOException $ex) {
            //throw $th;
            //echo $ex->getMessage();
        }
    }

    /**
     * Get the value of connexion
     */
    public function getConnexion()
    {
        return $this->connexion;
    }


    //Creation d'un utilisateur
    public function createUser(User $user)
    {
        $sql = "INSERT INTO " . DB_NAME . ".USERS (_id, full_name, email, password, created_at, updated_at) 
        VALUES (:_id, :full_name, :email, :password, :created_at, :updated_at)";

        try {
            //Préparation de la requête
            $request = $this->connexion->prepare($sql);

            //Exécution de la requête
            $result = $request->execute([
                //Mettre les informations sur les informations qu'on va renseigner
                ":_id" => $user->getId(),
                ":full_name" => $user->getFull_name(),
                ":email" => $user->getEmail(),
                ":password" => $user->getPassword(),
                ":created_at" => $user->getCreated_at(), // Formatage de la date
                ":updated_at" => $user->getUpdated_at() ? $user->getUpdated_at()->format('Y-m-d H:i:s') : null // Vérification si la date est définie
            ]);

            if ($result) {
                return $user->getId();
            } else {
                return false;
            }

        } catch (\PDOException $e) {
            //En cas d'erreur, retourner null
            echo $e->getMessage();
            return null;
        }
    }

    public function create(User|Category|Comment|Video|Review $objet)
    {


        if (gettype($objet) !== "object") {
            # code...
            return false;
        }

        //recuperer les tables stockées par defaut dans les attributs des entities
        $table = $objet->getTableName();

        if (!in_array($table, DB_TABLES)) {
            # Arretez le programme
            return false;
        }

        $columns = "";
        $values = "";

        switch ($table) {
            case 'USERS':
                $user = $objet;
                $columns .= "_id, full_name, email, password, created_at";
                $values .= "'" . $user->getId() . "',";
                $values .= "'" . $user->getFull_name() . "',";
                $values .= "'" . $user->getEmail() . "',";
                $values .= "'" . $user->getPassword() . "',";
                $values .= "'" . $user->getCreated_at() . "'";
                break;
            case 'CATEGORY':
                $category = $objet;
                $columns = "_id, name, description, created_at";
                $values .= "'" . $category->getId() . "',";
                $values .= "'" . $category->getName() . "',";
                $values .= "'" . $category->getDescription() . "',";
                $values .= "'" . $category->getCreated_at() . "'";
                break;
            case 'COMMENT':
                $comment = $objet;
                $columns = "_id, userId, videoId, content, created_at";
                $values .= "'" . $comment->getId() . "',";
                $values .= "'" . $comment->getUserId() . "',";
                $values .= "'" . $comment->getVideoId() . "',";
                $values .= "'" . $comment->getContent() . "'";
                $values .= "'" . $comment->getCreated_at() . "'";
                break;
            case 'REVIEWS':
                $review = $objet;
                $columns = "_id, userId, videoId, content, created_at";
                $values .= "'" . $review->getId() . "',";
                $values .= "'" . $review->getUserId() . "',";
                $values .= "'" . $review->getVideoId() . "',";
                $values .= "'" . $review->getContent() . "'";
                $values .= "'" . $review->getCreated_at() . "'";
                break;
            case 'VIDEOS':
                $video = $objet;
                $columns = "_id, name, slug, description, duration, categoryId, userId, userId, imageUrl, videoUrl, views, created_at";
                $values .= "'" . $video->getId() . "',";
                $values .= "'" . $video->getName() . "',";
                $values .= "'" . $video->getSlug() . "',";
                $values .= "'" . $video->getDescription() . "'";
                $values .= "'" . $video->getDuration() . "'";
                $values .= "'" . $video->getCategoryId() . "'";
                $values .= "'" . $video->getUserId() . "'";
                $values .= "'" . $video->getImageUrl() . "'";
                $values .= "'" . $video->getVideoUrl() . "'";
                $values .= "'" . $video->getViews() . "'";
                $values .= "'" . $video->getCreated_at() . "'";
                break;

            default:
                # code...
                break;
        }

        $sql = "INSERT INTO " . DB_NAME . ".$table ($columns) VALUES ($values)";


        try {


            //Préparation de la requête
            $request = $this->connexion->prepare($sql);

            //Exécution de la requête
            $result = $request->execute();

            if ($result) {
                return $objet->getId();
            } else {
                return false;
            }

        } catch (\PDOException $e) {
            //En cas d'erreur, retourner null
            echo $e->getMessage();
            return null;
        }
    }

    //Mettre à jour n'importe quelle table
    public function update(User|Category|Comment|Video|Review $objet)
    {


        if (gettype($objet) !== "object") {
            # code...
            return false;
        }

        //recuperer les tables stockées par defaut dans les attributs des entities
        $table = $objet->getTableName();

        if (!in_array($table, DB_TABLES)) {
            # Arretez le programme
            return false;
        }

        $values = "";

        switch ($table) {
            case 'USERS':
                $user = $objet;
                $newDate = (new DateTime())->format("Y-m-d H:i:s");
                $values .= "_id='" . $user->getId() . "', full_name='" . $user->getFull_name() . "', 
                        email='" . $user->getEmail() . "', updated_at='$newDate'";
                break;
            case 'CATEGORY':
                $category = $objet;
                $newDate = (new DateTime())->format("Y-m-d H:i:s");
                $values .= "_id='" . $category->getId() . "', name='" . $category->getName() . "', 
                        description='" . $category->getDescription() . "', updated_at='$newDate'";
                break;

            case 'COMMENT':
                $comment = $objet;
                $newDate = (new DateTime())->format("Y-m-d H:i:s");
                $values .= "_id='" . $comment->getId() . "', userId='" . $comment->getUserId() . "', videoId='" . $comment->getVideoId() . "', 
                        content='" . $comment->getContent() . "', updated_at='$newDate'";
                break;
            case 'REVIEWS':
                $review = $objet;
                $newDate = (new DateTime())->format("Y-m-d H:i:s");
                $values .= "_id='" . $review->getId() . "', userId='" . $review->getUserId() . "', videoId='" . $review->getVideoId() . "', 
                        content='" . $review->getContent() . "', updated_at='$newDate'";
                break;
            case 'VIDEOS':
                $video = $objet;
                $newDate = (new DateTime())->format("Y-m-d H:i:s");
                $values .= "_id='" . $video->getId() . "', name='" . $video->getName() . "', slug='" . $video->getSlug() . "', description='" . $video->getDescription() . "', 
                            duration='" . $video->getDuration() . "', 
                            categoryId='" . $video->getCategoryId() . "', 
                            userId='" . $video->getUserId() . "', 
                            imageUrl='" . $video->getImageUrl() . "', 
                            videoUrl='" . $video->getVideoUrl() . "', 
                            views='" . $video->getViews() . "', 
                            updated_at='$newDate'";
                break;

            default:
                # code...
                break;
        }

        $sql = "UPDATE " . DB_NAME . ".$table SET $values WHERE `_id`='" . $objet->getId() . "'";


        try {


            //Préparation de la requête
            $request = $this->connexion->prepare($sql);

            //Exécution de la requête
            $result = $request->execute();

            if ($result) {
                return $objet->getId();
            } else {
                return false;
            }

        } catch (\PDOException $e) {
            //En cas d'erreur, retourner null
            echo $e->getMessage();
            return null;
        }
    }

    //Lister Les utilisateur
    public function getUsers()
    {
        //Ecrire la requette
        $sql = "SELECT * FROM " . DB_NAME . ".USERS";
        //die($sql);

        //toujours penser au try and catch pour ne pas planter le programme
        try {
            //preparer la requette
            $request = $this->connexion->prepare($sql);

            //executer la requette 
            $request->execute();

            $users = [];

            while ($data = $request->fetch(PDO::FETCH_OBJ)) {
                # code...
                $user = (new User())->setId($data->_id)
                    ->setEmail($data->email)
                    ->setFull_name($data->full_name)
                    ->setUpdated_at($data->updated_at)
                    ->setCreated_at($data->created_at);

                $users[] = $user;
            }
            //$data = $request->fetch(PDO::FETCH_OBJ);

            if ($user) {
                # code...
                return $users;
            } else {
                # code...
                return false;
            }


        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    //Lister Les données d'une table passée en paramètre
    public function find($table)
    {



        if (!in_array($table, DB_TABLES)) {
            # Arretez le programme
            return false;
        }

        //Ecrire la requette
        $sql = "SELECT * FROM " . DB_NAME . "." . $table;
        //die($sql);

        //toujours penser au try and catch pour ne pas planter le programme
        try {
            //preparer la requette
            $request = $this->connexion->prepare($sql);

            //executer la requette 
            $request->execute();

            $results = [];

            while ($data = $request->fetch(PDO::FETCH_OBJ)) {
                # Les utilisateurs
                if ($table == "CATEGORY") {
                    # code...
                    $cat = (new Category())->setId($data->_id)
                        ->setName($data->name)
                        ->setDescription($data->description)
                        ->setCreated_at($data->created_at)
                        ->setUpdated_at($data->updated_at);

                    $results[] = $cat;
                }

                # Les utilisateurs
                if ($table == "USERS") {
                    # code...
                    $user = (new User())->setId($data->_id)
                        ->setEmail($data->email)
                        ->setFull_name($data->full_name)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $user;
                }

                # Les utilisateurs
                if ($table == "COMMENT") {
                    # code...
                    $comment = (new Comment())->setId($data->_id)
                        ->setContent($data->content)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $comment;
                }

                # Les utilisateurs
                if ($table == "REVIEWS") {
                    # code...
                    $review = (new Review())->setId($data->_id)
                        ->setContent($data->content)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $review;
                }

                # Les utilisateurs
                if ($table == "VIDEOS") {
                    # code...
                    $video = (new Video())->setId($data->_id)
                        ->setName($data->name)
                        ->setDescription($data->description)
                        ->setDuration($data->duration)
                        ->setUpdatedAt($data->updated_at)
                        ->setCreatedAt($data->created_at);

                    $results[] = $video;

                }


            }

            return $results;


        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    //Trouver un utilisateur par son id

    public function findById($table, $id)
    {



        if (!in_array($table, DB_TABLES)) {
            # Arretez le programme
            return false;
        }

        //Ecrire la requette
        $sql = "SELECT * FROM " . DB_NAME . "." . $table . " WHERE `_id` = '$id' ";
        //die($sql);

        //toujours penser au try and catch pour ne pas planter le programme
        try {
            //preparer la requette
            $request = $this->connexion->prepare($sql);

            //executer la requette 
            $request->execute();

            $results = [];

            while ($data = $request->fetch(PDO::FETCH_OBJ)) {
                # Les utilisateurs
                if ($table == "CATEGORY") {
                    # code...
                    $cat = (new Category())->setId($data->_id)
                        ->setName($data->name)
                        ->setDescription($data->description)
                        ->setCreated_at($data->created_at)
                        ->setUpdated_at($data->updated_at);

                    $results[] = $cat;
                }

                # Les utilisateurs
                if ($table == "USERS") {
                    # code...
                    $user = (new User())->setId($data->_id)
                        ->setEmail($data->email)
                        ->setFull_name($data->full_name)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $user;
                }

                # Les utilisateurs
                if ($table == "COMMENT") {
                    # code...
                    $comment = (new Comment())->setId($data->_id)
                        ->setContent($data->content)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $comment;
                }

                # Les utilisateurs
                if ($table == "REVIEWS") {
                    # code...
                    $review = (new Review())->setId($data->_id)
                        ->setContent($data->content)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $review;
                }

                # Les utilisateurs
                if ($table == "VIDEOS") {
                    # code...
                    $video = (new Video())->setId($data->_id)
                        ->setName($data->name)
                        ->setDescription($data->description)
                        ->setDuration($data->duration)
                        ->setUpdatedAt($data->updated_at)
                        ->setCreatedAt($data->created_at);

                    $results[] = $video;

                }


            }

            return isset($results[0]) ? $results[0] : false;


        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function findByEmail($table, $email)
    {



        if (!in_array($table, DB_TABLES)) {
            # Arretez le programme
            return false;
        }

        //Ecrire la requette
        $sql = "SELECT * FROM " . DB_NAME . "." . $table . " WHERE `email` = '$email' ";
        //die($sql);

        //toujours penser au try and catch pour ne pas planter le programme
        try {
            //preparer la requette
            $request = $this->connexion->prepare($sql);

            //executer la requette 
            $request->execute();

            $results = [];

            while ($data = $request->fetch(PDO::FETCH_OBJ)) {
                # Les utilisateurs
                if ($table == "CATEGORY") {
                    # code...
                    $cat = (new Category())->setId($data->_id)
                        ->setName($data->name)
                        ->setDescription($data->description)
                        ->setCreated_at($data->created_at)
                        ->setUpdated_at($data->updated_at);

                    $results[] = $cat;
                }

                # Les utilisateurs
                if ($table == "USERS") {
                    # code...
                    $user = (new User())->setId($data->_id)
                        ->setEmail($data->email)
                        ->setFull_name($data->full_name)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $user;
                }

                # Les utilisateurs
                if ($table == "COMMENT") {
                    # code...
                    $comment = (new Comment())->setId($data->_id)
                        ->setContent($data->content)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $comment;
                }

                # Les utilisateurs
                if ($table == "REVIEWS") {
                    # code...
                    $review = (new Review())->setId($data->_id)
                        ->setContent($data->content)
                        ->setUpdated_at($data->updated_at)
                        ->setCreated_at($data->created_at);

                    $results[] = $review;
                }

                # Les utilisateurs
                if ($table == "VIDEOS") {
                    # code...
                    $video = (new Video())->setId($data->_id)
                        ->setName($data->name)
                        ->setDescription($data->description)
                        ->setDuration($data->duration)
                        ->setUpdatedAt($data->updated_at)
                        ->setCreatedAt($data->created_at);

                    $results[] = $video;

                }


            }

            return isset($results[0]) ? $results[0] : false;


        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }


    //Mise à jour des données

    public function updateUser(User $user)
    {
        $sql = "UPDATE " . DB_NAME . ".`USERS` SET 
    `full_name`=:full_name,
    `email`=:email,
    `description`=:description,
    `updated_at`=:updated_at 
    WHERE `_id`=:id";


        try {
            //code...
            $request = $this->connexion->prepare($sql);

            $result = $request->execute(
                array(
                    ":id" => $user->getId(),
                    ":full_name" => $user->getFull_name(),
                    ":email" => $user->getEmail(),
                    ":description" => $user->getDescription(),
                    ":updated_at" => (new \DateTime())->format("Y-m-d H:i:s")
                )
            );

            return $result;

        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
            return null;
        }

        //echo $sql;
    }

    public function deleteUser(User $user)
    {

        $sql = "DELETE FROM " . DB_NAME . ".`USERS` WHERE `_id`=:id";

        try {
            //code...
            $request = $this->connexion->prepare($sql);

            $result = $request->execute(
                array(
                    ":id" => $user->getId()
                )
            );

            return $result;

        } catch (\Throwable $th) {
            //throw $th;
            //echo $th->getMessage();
            return null;
        }
    }

    //Supprimer n'importe qu'elle information d'une table!
    public function delete(User|Comment|Video|Review $objet)
    { //typage de $objet à objet

        try {

            if (gettype($objet) !== "object") {
                # code...
                return false;
            }

            //recuperer les tables stockées par defaut dans les attributs des entities
            $table = $objet->getTableName();

            if (!in_array($table, DB_TABLES)) {
                # Arretez le programme
                return false;
            }

            $sql = "DELETE FROM " . DB_NAME . ".$table WHERE `_id`=:id";
            $request = $this->connexion->prepare($sql);

            $result = $request->execute(
                array(
                    ":id" => $objet->getId()
                )
            );

            return $result;

        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
            return null;
        }
    }




}
