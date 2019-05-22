<?php

namespace Mada\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response
        return $this->app->response->redirect("movie/all-movies");
    }
    
    /**
     * Show all movies.
     */
    public function allMoviesActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Movie database | oophp";

        $db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
        ];

        $page->add("movie/header");
        $page->add("movie/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function searchTitleActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;
        $resultset = "";

        $title = "SELECT * WHERE title";
        $searchTitle = getGet("searchTitle");
        if ($searchTitle) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $resultset = $db->executeFetchAll($sql, [$searchTitle]);
        }

        $data = [
            "searchTitle" => $searchTitle,
            "resultset" => $resultset,
        ];

        $page->add("movie/header");
        $page->add("movie/search-title", $data);
        $page->add("movie/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function searchYearActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;
        $resultset = "";
        
        $title = "SELECT * WHERE year";
        $year1 = getGet("year1");
        $year2 = getGet("year2");
        $db->connect();
        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year2]);
        }

        $data = [
            "resultset" => $resultset,
        ];

        $page->add("movie/header");
        $page->add("movie/search-year", $data);
        $page->add("movie/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function editMovieAction($id) : object
    {
        $page = $this->app->page;
        $db = $this->app->db;
        $response = $this->app->response;

        $title = "Edit movie";

        $movieId    = getPost("movieId") ?: getGet("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear  = getPost("movieYear");
        $movieImage = getPost("movieImage");
        
        if (getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->connect();
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        }
        if (getPost("doDelete")) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->connect();
            $db->execute($sql, [$id]);
            return $response->redirect("movie/index");
        }
        $db->connect();
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $resultset = $db->executeFetch($sql, [$id]);
        $data = [
            "resultset" => $resultset,
        ];

        $page->add("movie/movie-edit", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function addMovieAction() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;

        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $db->connect();
        $db->execute($sql, ["A title", 2019, "img/noimage.png"]);
        $movieId = $db->lastInsertId();

        return $response->redirect("movie/edit-movie/$movieId");
    }
}
