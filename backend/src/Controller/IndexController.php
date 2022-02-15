<?php

namespace App\Controller;

use App\Service\Statistics\VisitorStatistics;
use Predis\Client;
use Snc\RedisBundle\Factory\PhpredisClientFactory;
use Snc\RedisBundle\Factory\PredisParametersFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class IndexController extends AbstractController
{
    /**
     * @param VisitorStatistics $statistics
     * @return Response
     */
    #[Route('/api/visits', name: 'visits_index', methods: ['GET'])]
    public function index(VisitorStatistics $statistics): Response
    {
        return $this->json(['message' => $statistics->get()]);
    }

    /**
     * @param Request $request
     * @param VisitorStatistics $statistics
     * @return Response
     */
    #[Route('/api/visits', name: 'visits_update', methods: ['POST'])]
    public function update(Request $request, VisitorStatistics $statistics): Response
    {
        $code = $request->get('code');

        try {
            $statistics->increment($code);
        } catch (\InvalidArgumentException $exception) {
            throw new BadRequestException($exception->getMessage());
        }

        return new JsonResponse();
    }
}
