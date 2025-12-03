<?php

namespace App\Services\Grade;

use Illuminate\Support\Facades\Http;



class OpenAIEmbeddingService {

    public array $embeddings = [];

    public string $api_key;

    public string $url = 'https://api.openai.com/v1/embeddings';

    public function __construct(){
        $this->api_key = env('OPENAI_API_KEY');
    }


    public function embedding(array $inputs){

        $batchedEmbeddings = [];

        //Separating from null since frickin OpenAI cannot receive null value

        $cleanInputs = array_values(array_filter($inputs, fn($i) => !empty($i)));

        $response = Http::withToken($this->api_key)
                        ->post($this->url,[

                            'model' => 'text-embedding-3-small',
                            'input' => $cleanInputs

                        ])->json();

        if (isset($response['error'])) {
            return ['error' => $response['error']];
        }


        //Merging response with initial input into batchedEmbeddings

        $responseIndex = 0;

        foreach ($inputs as $index => $input) {

            if ($input != null) {
                $batchedEmbeddings[$index] = [
                    'embedding' => $response['data'][$responseIndex]['embedding']
                ];
                $responseIndex += 1;
            } else {
                $batchedEmbeddings[$index] = [
                    'embedding' => null
                ];
            }
        }

        return $batchedEmbeddings;

    }
}

