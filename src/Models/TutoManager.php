<?php

namespace tutoAPI\Models;

use tutoAPI\Services\Manager;

class TutoManager extends Manager
{
    //fonction qui permet de récupérer un tuto en particulier
    public function find($id)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        // Instanciation d'un tuto
        $tuto = new Tuto();
        $tuto->setId($result["id"]);
        $tuto->setTitle($result["title"]);
        $tuto->setDescription($result["description"]);
        $tuto->setCreatedAt($result["createdAt"]);

        // Retour
        return $tuto;
    }

    //fonction qui permet de récupérer l'ensemble des tutos
    public function findAll()
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos');
        $sth->execute();

        $tutos = [];

        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;

        }

        return $tutos;

    }


    //pagination
    public function findPaginate(){
    $sth->bindParam(':page', $page, \PDO::PARAM_INT);
    if( $page == 0 ){
        $sth = $dbh->prepare('SELECT * FROM tutos');
    }else{
        $page = $page5-5;
        $sth = $dbh->prepare('SELECT FROM tutos LIMIT 5 OFFSET :page ');
        $sth->bindParam(':page', $page, \PDO::PARAM_INT);
    }

    if(isset($_GET["page"])){
        $page = $_GET["page"];
        $tutos = $manager->findAll($page);
    }else{
        $tutos = $manager->findAll();
    }
    }

    //fonction qui permet d'ajouter un tuto à la base de données
    public function add($_PATCH)
    {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sql = 'INSERT INTO tutos (title, description, createdAt) VALUES (?,?,?)';
        $sth= $dbh->prepare($sql);
        $result = $sth->execute([$_PATCH->title, $_PATCH->description, $_PATCH->createdAt]);

        // Retour
        return $result;
    }

    //fonction qui permet de modifier un tuto en particulier
    public function update($_PATCH, $id){

       // Modification d'un tuto en BDD

       // Connexion à la BDD
       $dbh = static::connectDb();

       // Requête
       $sth = $dbh->prepare('UPDATE `tutos` SET `title`= :title ,`description`= :decription ,`createdAt`= :createdAt WHERE id = :id');
       $sth->bindParam(':id', $id, \PDO::PARAM_INT);
       $sth->bindParam(':title', $_PATCH->title);
       $sth->bindParam(':decription', $_PATCH->description);
       $sth->bindParam(':createdAt', $_PATCH->createdAt);
       $sth->execute();

       // Requête
       $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
       $sth->bindParam(':id', $id, \PDO::PARAM_INT);
       $sth->execute();
       $result = $sth->fetch(\PDO::FETCH_ASSOC);

       // Instanciation d'un tuto
       $tuto = new Tuto();
       $tuto->setId($result["id"]);
       $tuto->setTitle($result["title"]);
       $tuto->setDescription($result["description"]);
       $tuto->setCreatedAt($result["createdAt"]);


       // Retour
       return $result;

    }

    //fonction qui permet de supprimer un tuto
    public function delete($id)
    {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sql = 'DELETE FROM tutos WHERE id = :id';
        $sth= $dbh->prepare($sql);
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $result = $sth->execute();

        // Retour
        return $result;
    }
}
