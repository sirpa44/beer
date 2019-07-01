<?php declare(strict_types=1);

namespace App\Service;

class FridgeCalculator
{
    /**
     * get the ratio of beer in the fridge
     * @param array $data
     * @return float
     */
    public function getRatio(array $data): float
    {
        $totalBeer = 0;
        $totalCapacity = 0;

        foreach ($data as $fridge) {
            $totalBeer = $totalBeer + $fridge['beer'];
            $totalCapacity = $totalCapacity + $fridge['capacity'];
        }

        return $totalBeer / $totalCapacity;
    }

    /**
     *  add correction Value to $data Array.
     *
     * @param array $data
     * @param float $ratio
     * @return array
     */
    public function setCorrectionValue(array $data, float $ratio): array
    {
        $updatedArray = [];
        foreach ($data as $fridge) {
            $beerExpected = $fridge['capacity'] * $ratio;
            $fridge['correctionNumber'] =  $beerExpected - $fridge['beer'];
            $updatedArray[] = $fridge;
        }
        return $updatedArray;
    }

    public function correctionArray(array $data)
    {
        $correction = [];
        foreach ($data as $source) {
            if ($source['correctionNumber'] < 0) {
                foreach ($data as $destination) {
                    if ($destination['correctionNumber'] > 0 && $source['correctionNumber'] < 0) {
                        if (-$source['correctionNumber'] <= $destination['correctionNumber']) {
                            $exchangeValue = -$source['correctionNumber'];
                        } else {
                            $exchangeValue = $destination['correctionNumber'];
                        }
                        $correction[] = [
                            'source' => $source['name'],
                            'destination' => $destination['name'],
                            'amount' => $exchangeValue
                        ];
                        $source['beer'] = $source['beer'] - $exchangeValue;
                        $destination['beer'] = $destination['beer'] + $exchangeValue;
                    }
                }
            }
        }
        return $correction;
    }
}