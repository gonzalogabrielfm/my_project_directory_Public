<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Service\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CarRepository;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    public function __construct(
        private readonly CarRepository $carRepository,
        private readonly BrandRepository $brandRepository,
        private readonly CacheManager  $cacheManager

    )    {
    }

    #[Route('/hello/demo', name: 'app_hello_demo')]
    public function helloDemo(): Response
    {
        $carsInfo = $this->cacheManager->get('carsInfo');
        if (!$carsInfo) {
            $numberOfToyota = count($this->carRepository->findCarsWithCertainName("Fiesta"));
            $carsInfo = ['number_cars' => $numberOfToyota];
            $this->cacheManager->set('carsInfo', json_encode($carsInfo));
        } else {
            $carsInfo = json_decode($carsInfo, true);
        }

        $allFiestas = $this->carRepository->findCarsWithCertainName("Fiesta");

        return $this->render(
            'demo/hello_demo.html.twig',
            [
                'cars' => $allFiestas,
                'carsInfo' => $carsInfo
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
