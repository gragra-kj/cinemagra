<?php

class Movie
{
    private $movie_id;
    private $movieName;
    private $movieDescription;
    private $movieImage;
    private $movietrailer;
    private $genre;

    function __construct($movie_id, $movieName, $movieDescription, $movieImage,$movietrailer,$genre)
    {
        $this->movie_id = $movie_id;
        $this->movieName = $movieName;
        $this->movieDescription = $movieDescription;
        $this->movieImage = $movieImage;
        $this->movietrailer=$movietrailer;
        $this->genre=$genre;
    }
    public function deleteMovie()
    {
        include "../db.php";

        $query = "DELETE FROM movies WHERE movie_id = $this->movie_id ";

        if ($conn->query($query) == true) {
            header("Location: ../addMovie.php?movieDeleted=success");
            exit();
        } else {
            header("Location: ../addMovie.php?movieDeleted=failed");
            exit();
        }
    }public function editMovies()
    {
        include "../db.php";

        $query = "UPDATE movies
                    SET movieName = '$this->movieName',
                        movieDescription = '$this->movieDescription',
                        movieImage = '$this->movieImage',
                        trailers='$this->movietrailer',
                        genre='$this->genre
                    WHERE movie_id = $this->movie_id
                    ";

        if ($conn->query($query) == true) {
            header("Location: ../addMovie.php?movieEdited=success");
            exit();
        } else {
            header("Location: ../addMovie.php?movieEdited=failed");
            exit();
        }
    }
    
}
if (isset($_GET['deleteMovie'])) {// check if delete button was pressed

    $deleteMovie = new Movie($_GET['deleteMovie'], null, null, null,null,null); //we put null to the other parameters as we don't need them

    $deleteMovie->deleteMovie();
}

if(isset($_POST['submit-movieUP'])){// check if edit button was pressed

    $image = addslashes(file_get_contents($_FILES['movieImage']['tmp_name']));

    $updateMovie = new Movie($_POST['movie_idH'], $_POST['movieName'], $_POST['movieDescription'],$_POST['trailers'],$_POST['genre'], $image); 

    $updateMovie->editMovies();

}