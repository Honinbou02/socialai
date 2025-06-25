<?php

namespace App\Services;

class ImageModel
{
    private $model;

    public function __construct($modelType)
    {
        $this->createAiModel($modelType);
    }

    private function createAiModel($modelType)
    {
        switch ($modelType) {
            case 'stability_ai':
                $this->model = new StabilityAi();
                break;
            case 'dalle_3':
                $this->model = new AiTool();
                break;
            default:
                $this->model = new StableDiffusion();
                break;
        }
    }

    public function generateImage($prompt, $meta)
    {
        if ($prompt['image_ai_model'] == 'stability_ai') {
            return $this->model->generateImage($prompt['text'], $meta['seed'], $meta['negative_prompt'], $meta['aspect_ratio']);
        } elseif ($prompt['image_ai_model'] == 'dalle_3') {
            return $this->model->generateImage($prompt['text'], 1, $meta['image_size'] ?? '1024x1024');
        } else {
            return $this->model->generateImage(
                $prompt['text'],
                $meta['image_width'] ?? 512,
                $meta['image_height'] ?? 512,
                1,
                $meta['guidance_scale'],
                $meta['seed'],
                $meta['negative_prompt'],
            );
        }
    }
}
