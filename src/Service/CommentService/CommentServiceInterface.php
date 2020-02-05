<?php


namespace App\Service\CommentService;


use App\Entity\Comments;
use Symfony\Component\HttpFoundation\Request;

interface CommentServiceInterface
{
	function add(Comments $comment);
	function collection(Request $request);
}