<?php

namespace App\Services\Grade;

class CosineSimilarityService
{
    public array $similarityScores = [];

    /*
        $batchedEmbeddings = [1+]['embedding' => [student answer embedding value elements]]
        $batchedEmbeddings = [0]['embedding' => [teacher ref_answer embedding value elements]]
    */
    public function similarity(array $batchedEmbeddings): array
    {
        $this->similarityScores = [];


        $refItem = array_shift($batchedEmbeddings);

        $refVector = $this->extract_vector($refItem);

        foreach ($batchedEmbeddings as $index => $answerItem) {
            $answerVector = $this->extract_vector($answerItem);

            if ($refVector === null || $answerVector === null) {
                // If either is missing, similarity is 0
                $this->similarityScores[$index] = 0.0;
                continue;
            }

            $this->similarityScores[$index] = $this->cosine_similarity($refVector, $answerVector);
        }

        return $this->similarityScores;
    }

    /**
     * Safely extract a numeric vector from $item.
     * Returns array of floats or null.
     */
    private function extract_vector($item): ?array
    {
        if ($item === null) {
            return null;
        }


        //checking array whether assoc or not and with embedding key

        if (is_array($item) && array_key_exists('embedding', $item) && is_array($item['embedding'])) {
            return $this->normalize_vector($item['embedding']);
        }

        if (is_array($item)) {
            return $this->normalize_vector($item);
        }

        return null;
    }

    /**
     * Ensure all elements are floats and remove non-numeric entries. This wont affect anything
     * If the OpenAI embedding return correct embedding vectors.
     */
    private function normalize_vector(array $vec): ?array
    {
        $out = [];
        foreach ($vec as $v) {
            if (!is_numeric($v)) {
                // skip non-numeric entries
                continue;
            }
            $out[] = (float) $v;
        }

        return count($out) ? $out : null;
    }

    /**
     * Return vector length for denominator on cosine similarity formula
     */
    public function vector_length(?array $vector): float
    {
        if ($vector === null) {
            return 0.0;
        }

        $sum_squared = 0.0;
        foreach ($vector as $element) {
            $sum_squared += $element * $element;
        }

        return sqrt($sum_squared);
    }

   /*
        Dot Product for nominator on the cosine similarity formula
    */
    private function vector_multiplier(?array $a, ?array $b): float
    {
        if ($a === null || $b === null) {
            return 0.0;
        }

        $sum = 0.0;
        $len = min(count($a), count($b));

        for ($i = 0; $i < $len; $i++) {
            $sum += $a[$i] * $b[$i];
        }

        return $sum;
    }

   /*
    Calculating similarity of 2 vector. Used for each element inside answerEmbedding array
   */
    private function cosine_similarity(array $refVector, array $answerVector): float
    {
        $dot = $this->vector_multiplier($refVector, $answerVector);

        $lenA = $this->vector_length($refVector);
        $lenB = $this->vector_length($answerVector);

        $den = $lenA * $lenB;

        if ($den == 0.0) {
            return 0.0; // avoid division by zero
        }

        return $dot / $den;
    }
}
