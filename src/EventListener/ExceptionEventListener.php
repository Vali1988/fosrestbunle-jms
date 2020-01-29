<?php


namespace App\EventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionEventListener
{
	public function onKernelException(ExceptionEvent $event)
	{
		$exception = $event->getThrowable();
		dd($exception);
	}
}