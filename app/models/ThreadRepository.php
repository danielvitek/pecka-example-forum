<?php


namespace App\Models;


use Core\Repository;
use PDO;

class ThreadRepository extends Repository
{
    /**
     * @param string $name Thread name
     *
     * @return mixed
     */
    public function get(string $name): mixed
    {
        return $this->database
            ->query('SELECT * FROM thread WHERE name = ?', $name)
            ->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getThreads(): array
    {
        return $this->database
            ->query('SELECT * FROM thread ORDER BY date_created DESC')
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id Post ID
     *
     * @return array
     */
    public function getThreadPosts(int $id): array
    {
        return $this->database
            ->query('
                    SELECT *, (SELECT COUNT(*) FROM thread_post WHERE author = tp.author) AS author_posts_count
                    FROM thread_post tp
                    WHERE thread_id = ? 
                    ORDER BY date_created DESC
                ', $id)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     *
     * @return int|false
     *
     * @noinspection NonSecureUniqidUsageInspection
     */
    public function createThread(array $data): int|false
    {
        $data['name'] = uniqid() . '-' . preg_replace('/[^a-z0-9-_]/', '-', strtolower($data['title']));

        $this->database->query(
            'INSERT INTO thread (name, title, author) VALUES (?, ?, ?)',
            $data['name'],
            $data['title'],
            $data['author']
        );

        return $this->database->lastId() ?: false;
    }

    /**
     * @param $threadId
     * @param $data
     */
    public function createPost($threadId, $data)
    {
        $this->database->query(
            'INSERT INTO thread_post (thread_id, author, content) VALUES (?, ?, ?)',
            $threadId,
            $data['author'],
            $data['content']
        );

        return $this->database->lastId() ?: false;
    }
}