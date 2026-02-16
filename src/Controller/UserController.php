<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CarRepository;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )    {
    }
    #[Route('/hello/users', name: 'app_hello_users')]
    public function helloDemo(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render(
            'demo/hello_users.html.twig',
            [
                'users' => $users,
            ]
        );
    }


    #[Route('/get/users', name: 'app_get_users')]
    public function getUsers(): Response
    {
        $users = $this->userRepository->findAll();

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'userId' => $user->getId(),
                'userName' => $user->getUsername(),
            ];
        }


        return new JsonResponse($data);
    }

    #[Route('/hello/user/{id}', name: 'app_get_users')]
    public function userById(int $id): Response
    {
        $user = $this->userRepository->find($id);

        return $this->render(
            'demo/hello_user.html.twig',
            [
                'user' => $user,
            ]
        );
    }
}
