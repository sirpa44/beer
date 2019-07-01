<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\FridgeCalculator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController
{

    /**
     * @var FridgeCalculator
     */
    private $fridgeCalculator;

    public function __construct(FridgeCalculator $fridgeCalculator)
    {
        $this->fridgeCalculator = $fridgeCalculator;
    }

    /**
     * @param Request $request
     * @Route("/beer", methods={"POST"})
     * @return JsonResponse
     */
    public function getTransactionInstruction(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        $ratio = $this->fridgeCalculator->getRatio($data);
        $updatedData = $this->fridgeCalculator->setCorrectionValue($data, $ratio);
        $transactionInstruction = $this->fridgeCalculator->correctionArray($updatedData);
        return new JsonResponse($transactionInstruction);
    }
}