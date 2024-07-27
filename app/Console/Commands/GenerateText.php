<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;

class GenerateText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:text {prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate text using OpenAI API';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prompt = $this->argument('prompt');

        try {
            // Call OpenAI API
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $text = $response->choices[0]->message->content;
            $this->info('Generated Text:');
            $this->line($text);

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
