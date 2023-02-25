<?php

namespace HackbartPR\Repository;

use PDO;
use HackbartPR\Entity\Video;
use HackbartPR\Interfaces\VideoRepository;

class PDOVideoRepository implements VideoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Video $video):bool
    {        
        if (!empty($video->id())) {
            return $this->update($video);
        }

        return $this->add($video);
    }

    public function add(Video $video): bool
    {
        
        $stmt = $this->pdo->prepare('INSERT INTO videos (url, title, image_path) VALUES (:url, :title, :image_path);');
        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->title);
        $stmt->bindValue(':image_path', $video->image_path());
        
        return $stmt->execute();
    }

    public function update(Video $video):bool
    {
        $stmt = $this->pdo->prepare('UPDATE videos SET url = :url, title = :title, image_path = :image_path WHERE id = :id;');
        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->title);
        $stmt->bindValue(':id', $video->id());
        $stmt->bindValue(':image_path', $video->image_path());
        
        return $stmt->execute();        
    }

    public function remove(int $id): bool
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
         
        $stmt = $this->pdo->prepare('DELETE FROM videos WHERE id = ?');
        $stmt->bindValue(1, $_GET['id'], \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM videos');
        $videoDataList = $stmt->fetchAll();

        $videoList = [];
        foreach ($videoDataList as $video) {
            $videoList[] = new Video($video['id'], $video['title'], $video['url'], $video['image_path']);
        }

        return $videoList;
    }

    public function show(int $id): Video
    {   
        $id = filter_var($id, FILTER_VALIDATE_INT); 
        
        $stmt = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?');
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $video = $stmt->fetch();

        return new Video($video['id'], $video['title'], $video['url'], $video['image_path']);
    }
}