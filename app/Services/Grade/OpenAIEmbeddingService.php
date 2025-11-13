<?php

namespace App\Services\Grade;

use Illuminate\Support\Facades\Http;



class OpenAIEmbeddingService {

    public string $api_key;

    public string $url = 'https://api.openai.com/v1/embeddings';

    public function __construct(){
        $this->api_key = env('OPENAI_API_KEY');
    }


    public function embedding(array $answers){

        $response = Http::withToken($this->api_key)
                        ->post($this->url,[

                            'model' => 'text-embedding-003-small',
                            'input' => $answers

                        ]);

    }
}

