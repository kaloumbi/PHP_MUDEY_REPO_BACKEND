<?php 

use entity\Category;
use entity\User;
use Model\Repository;

require_once("config.php");
require_once("model/Repository.php");
require_once("lib/utilities.php");
require_once("entity/User.php");
require_once("entity/Category.php");

$repo = new Repository();

//Charger les données de l'utilisateur
$user = (new User)->setEmail("fama@gmail.com")
                  ->setFull_name("Fama DIEDHIOU")
                  ->setPassword("passer");

$category = (new Category())->setName("Article")
                            ->setDescription("Le meilleur des articles !!!");

//$result = $repo->createUser($user);
//$result = $repo->create($category);

//var_dump($result);

//Lister les données de l'utilisateur
//$users = $repo->getUsers();
$user = $repo->find("USERS")[0];

        $user->setEmail("maman@gmail.com");

$repo->update($user);

var_dump($user);
//$user = $repo->findById("USERS", "au53yffbAaVFduv");
//$user = $repo->findByEmail("USERS", "deleteme@gmail.com");

//$user->setDescription("La meilleure Eleve de sa generation");

//$result = $repo->updateUser($user);

//$result = $repo->deleteUser($user);

//$result = $repo->delete($user);

//var_dump($result);