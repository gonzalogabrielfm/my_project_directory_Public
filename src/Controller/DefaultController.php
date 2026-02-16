<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CarRepository;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    public function __construct(
        private readonly CarRepository $carRepository,
        private readonly BrandRepository $brandRepository,

    )    {
    }
    #[Route('/hello/demo', name: 'app_hello_demo')]
    public function helloDemo(): Response
    {
        $firstCar = $this->carRepository->find(1);
        return $this->render(
            'demo/hello_demo.html.twig',
            [
                'text' => $firstCar->getName(),
            ]
        );
    }

    #[Route('/hello/car/{carId}', name: 'app_get_car')]
    public function carById(int $carId): Response
    {
        $car = $this->carRepository->find($carId);

        return $this->render(
            'demo/conditional_car.html.twig',
            [
                'car' => $car,
            ]
        );
    }

    #[Route('/hello/cars/{brandId}', name: 'app_get_cars')]
    public function carsById(int $brandId): Response
    {
        $cars = $this->carRepository->findBy([
            'brand' => $brandId
        ]);
        $brand = $this->brandRepository->find($brandId);

        return $this->render(
            'demo/hello_cars.html.twig',
            [
                'cars' => $cars,
                'brand' => $brand
            ]
        );
    }
}
