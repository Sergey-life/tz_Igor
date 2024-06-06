<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected array $parameters;
    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, array $parameters)
    {
        $this->post = $post;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->post->update($this->parameters);
    }
}
