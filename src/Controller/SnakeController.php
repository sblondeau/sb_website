<?php

namespace App\Controller;

use Exception;
use App\Entity\Map;
use App\Entity\Snake;
use RuntimeException;
use App\Entity\SnakeBlock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/snake', name: 'snake_')]
class SnakeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has('map')) {
            $snake = new Snake();
            $session->set('map', new Map(20, $snake));
            $snake->addBlock(new SnakeBlock(4, 5));
            $snake->addBlock(new SnakeBlock(3, 5));
        }

        return $this->render('snake/index.html.twig', [
            'map' => $session->get('map'),
        ]);
    }

    #[Route('/direction/{direction}', name: 'move')]
    public function move(string $direction, SessionInterface $session): Response
    {
        $map = $session->get('map');
        try {
            $map->getSnake()->changeDirection($direction);
        } catch (Exception $exception) {
            $error = $exception->getMessage();
        }
        $session->set('map',  $map);

        return new Response($error ?? '');
    }

    #[Route('/turn', name: 'turn')]
    public function turn(SessionInterface $session): Response
    {
        $map = $session->get('map');
        if ($map instanceof Map) {
            try {
                $map->turn();
            } catch (RuntimeException $exception) {
                $error = $exception->getMessage();
                exit();
            } catch (Exception $exception) {
                $error = $exception->getMessage();
            }
            $session->set('map',  $map);
        }
        return $this->render('snake/_map.html.twig', [
            'map' => $session->get('map'),
            'error' => $error ?? '',
        ]);
    }

    #[Route('/reset', name: 'reset')]
    public function reset(SessionInterface $session): Response
    {
        if ($session->has('map')) {
            $session->remove('map');
        }

        return $this->redirectToRoute('snake_index');
    }
}
