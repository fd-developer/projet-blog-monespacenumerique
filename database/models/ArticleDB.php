<?php

class ArticleDB
{

    private PDOStatement $statementReadOne;
    private PDOStatement $statementReadAll;
    private PDOStatement $statementCreateOne;
    private PDOStatement $statementUpdateOne;
    private PDOStatement $statementDeleteOne;
    private PDOStatement $statementReadUserAll;


    function __construct(private PDO $pdo)
    {
        $this->statementReadOne = $pdo->prepare('select article.*, user.firstname, user.lastname from article LEFT JOIN user ON article.author = user.id WHERE article.id = :id');
        $this->statementReadAll = $pdo->prepare('select article.*, user.firstname, user.lastname from article LEFT JOIN user ON article.author = user.id');

        $this->statementCreateOne = $pdo->prepare(
            'insert into article (title, category, content, image, author) 
            values (:title, :category, :content, :image, :author)'
        );

        $this->statementUpdateOne = $pdo->prepare(
            'update article 
            set title = :title, category = :category, content = :content, image = :image,
            author = :author  
            where id = :id'
        );

        $this->statementDeleteOne = $pdo->prepare('delete from article where id = :id');

        $this->statementReadUserAll = $pdo->prepare('select * from article where article.author = :authorId');
    }

    public function fetchAll()
    {
        $this->statementReadAll->execute();
        return $this->statementReadAll->fetchAll();
    }

    public function fetchOne(int $id)
    {
        $this->statementReadOne->bindValue(':id', $id);
        $this->statementReadOne->execute();
        return $this->statementReadOne->fetch();
    }

    public function deleteOne(int $id)
    {
        $this->statementDeleteOne->bindValue(':id', $id);
        $this->statementDeleteOne->execute();
    }

    public function createOne($article)
    {
        $this->statementCreateOne->bindValue(':title', $article['title']);
        $this->statementCreateOne->bindValue(':category', $article['category']);
        $this->statementCreateOne->bindValue(':content', $article['content']);
        $this->statementCreateOne->bindValue(':image', $article['image']);
        $this->statementCreateOne->bindValue(':author', $article['author']);

        $this->statementCreateOne->execute();
        return $this->fetchOne($this->pdo->lastInsertId());
    }

    public function updateOne($article)
    {
        $this->statementUpdateOne->bindValue(':id', $article['id']);
        $this->statementUpdateOne->bindValue(':title', $article['title']);
        $this->statementUpdateOne->bindValue(':category', $article['category']);
        $this->statementUpdateOne->bindValue(':content', $article['content']);
        $this->statementUpdateOne->bindValue(':image', $article['image']);
        $this->statementUpdateOne->bindValue(':author', $article['author']);
        $this->statementUpdateOne->execute();
        return $article;
    }

    public function fetchUserArticle($authorId): array
    {
        $this->statementReadUserAll->bindValue(':authorId', $authorId);
        $this->statementReadUserAll->execute();
        return $this->statementReadUserAll->fetchAll();
    }
}

return new ArticleDb($pdo);
