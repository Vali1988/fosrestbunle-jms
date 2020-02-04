<?php


namespace App\Service\CommentService;


use App\Entity\Comments;

interface CommentServiceInterface
{
	function add(Comments $comment);
}