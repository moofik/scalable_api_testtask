<?php

namespace App\EventSubscriber;

use App\Service\Api\Problem\ApiProblem;
use App\Service\Api\Problem\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonRequestFillerSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * RequestFillerSubscriber constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [
                ['fillRequestFromJsonContent', 1000],
            ],
        ];
    }

    public function fillRequestFromJsonContent()
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            throw new HttpException(500, 'internal server error: request not found');
        }

        if ('json' !== $request->getContentType() || !$request->getContent()) {
            return;
        }

        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new BadRequestException(400, 'invalid json');
        }

        $request->request->replace(is_array($data) ? $data : []);
    }
}