<?php

namespace Mada\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

class ContentController implements AppInjectableInterface
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
        return $this->app->response->redirect("content/show-all");
    }
    
    /**
     * Show all movies.
     */
    public function showAllActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Show all | content";

        $db->connect();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
        ];

        $page->add("content/header");
        $page->add("content/show-all", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function adminActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Admin | content";

        $db->connect();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "resultset" => $res,
        ];

        $page->add("content/header");
        $page->add("content/admin", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function createActionGet() : object
    {
        $page = $this->app->page;

        $page->add("content/header");
        $page->add("content/create");

        return $page->render();
    }

    public function createActionPost() : object
    {
        $response = $this->app->response;
        $db = $this->app->db;

        $title = getPost("contentTitle");

        $db->connect();
        $sql = "INSERT INTO content (title) VALUES (?);";
        $db->execute($sql, [$title]);
        $contentId = $db->lastInsertId();

        return $response->redirect("content/edit/$contentId");
    }

    public function editActionGet($id = null) : object
    {
        $mess = null;

        $page = $this->app->page;
        $db = $this->app->db;
        
        if (!is_numeric($id)) {
            die("Not valid for content id.");
        }

        $title = "Edit | content";

        $db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";
        $res = $db->executeFetch($sql, [$id]);
        $mess = $this->app->session->get("mess");

        $data = [
            "content" => $res,
            "mess" => $mess,
        ];

        $page->add("content/header");
        $page->add("content/edit", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost($id) : object
    {
        $mess = null;
        $this->app->session->set("mess", null);

        $page = $this->app->page;
        $db = $this->app->db;
        $response = $this->app->response;
        $title = "Edit";

        if (!is_numeric($id)) {
            die("Not valid for content id.");
        }
        
        if (getPost("doDelete")) {
            $db->connect();
            $sql = "SELECT * FROM content WHERE id = ?;";
            $res = $db->executeFetch($sql, [$id]);
            $page->add("content/header");
            $page->add("content/delete", ["content" => $res]);
            return $page->render([
                "title" => $title,
            ]);
        } elseif (getPost("doSave")) {
            $params = getPost([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);
            $slug = getPost("contentSlug");
            $contentId = getPost("contentId");
            $db->connect();
            
            $sql = "SELECT * FROM content WHERE slug= ?";
            $dbSlug = $db->executeFetchAll($sql, [$slug]);

            if (count($dbSlug) > 0 && $dbSlug[0]->title != $slug) {
                $mess = "Slug must be uniqe";
                $this->app->session->set("mess", $mess);
                return $response->redirect("content/edit/$contentId");
            }
            // $sql = "SELECT slug FROM content;";
            // $dbSlug = $db->executeFetchAll($sql);
            // $counter = 0;

            // foreach ($dbSlug as $old) {
            //     if ($slug == $old) {
            //         return $response->redirect("content/edit/$id");
            //     }
            // }

            if (!$params["contentSlug"]) {
                $params["contentSlug"] = slugify($params["contentTitle"]);
            }

            if (!$params["contentPath"]) {
                $params["contentPath"] = null;
            }
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($sql, array_values($params));
        }

        return $response->redirect("content/edit/$contentId");
    }

    public function deleteActionGet($id) : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Delete | content";
        $db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";
        $res = $db->executeFetch($sql, [$id]);

        $data = [
            "content" => $res,
        ];

        $page->add("content/header");
        $page->add("content/delete", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function deleteActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;

        $contentId = getPost("contentId") ?: getGet("id");
        if (!is_numeric($contentId)) {
            die("Not valid for content id.");
        }

        if (hasKeyPost("doDelete")) {
            $contentId = getPost("contentId");
            $db->connect();
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $db->execute($sql, [$contentId]);
            return $response->redirect("content/admin");
        }
    }

    public function pagesActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Pages | content";
        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE 
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        $resultset = $db->executeFetchAll($sql, ["page"]);

        $data = [
            "resultset" => $resultset,
        ];

        $page->add("content/header");
        $page->add("content/pages", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function pageActionGet($id) : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Page | content";
        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    id = ?
    AND published <= NOW()
;
EOD;
        $content = $db->executeFetch($sql, [$id]);
        $fil = new \Mada\Content\ContentTextFilter();
        $modified = $fil->parse($content->data, $content->filter);

        $data = [
            "content" => $content,
            "modified" => $modified,
        ];

        $page->add("content/header");
        $page->add("content/page", $data);
        
        return $page->render([
            "title" => $title,
        ]);
    }

    public function blogActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Blog | content";
        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        $content = $db->executeFetchAll($sql, ["post"]);

        $data = [
            "content" => $content,
        ];

        $page->add("content/header");
        $page->add("content/blog", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function blogPostActionGet($id) : object
    {
        $page = $this->app->page;
        $db = $this->app->db;

        $title = "Blog | content";
        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE 
    id = ?
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $content = $db->executeFetch($sql, [$id]);
        // echo($content);
        $fil = new \Mada\Content\ContentTextFilter();
        $modified = $fil->parse($content->data, $content->filter);

        $data = [
            "content" => $content,
            "modified" => $modified,
        ];

        $page->add("content/header");
        $page->add("content/blogpost", $data);
        
        return $page->render([
            "title" => $title,
        ]);
    }

    public function resetActionGet() : object
    {
        $page = $this->app->page;

        $page->add("content/header");
        $page->add("content/reset");

        return $page->render([
            "title" => "Reset database",
        ]);
    }
}
