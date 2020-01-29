<?php


namespace App\Service\UserService;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserServiceInterface
{
	function checkRights(User $user, array $parameters);
	function add(User $user);
	function deleteUser(User $user);
	function updateUser(User $user);
	function collection(Request $request);
	function item(string $slug, string $identifier = 'id');
}