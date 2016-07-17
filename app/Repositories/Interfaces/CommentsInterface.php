<?php namespace App\Repositories\Interfaces;


use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;

interface CommentsInterface
{

  public function createComment(User $user, Post $post, $content, Comment $parent = null);

  public function findCommentWithException($commentId);

  public function findComment($commentId);

}