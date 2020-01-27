<?php


namespace App\Service\UserService;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserServiceInterface
{
	function checkRights(User $user, array $parameters);
	function add(User $user);
	function delete(User $user);
	function update(User $user);
	function collection(Request $request);
	function item(User $user);
}