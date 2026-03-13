<?php

namespace App\Services;

use App\Models\Template;

class BlockContentService
{
    /**
     * Recursively resolve template references in a block structure.
     */
    public function resolveReferences(array $content, int $depth = 0): array
    {
        if ($depth > 5) return $content; // Prevent infinite recursion

        return array_map(function ($block) use ($depth) {
            if (!is_array($block) || !isset($block['type'])) return $block;

            // 1. Resolve template references
            if ($block['type'] === 'template_reference') {
                $templateId = $block['content']['template_id'] ?? null;
                if ($templateId) {
                    $template = Template::find($templateId);
                    if ($template) {
                        $block['content']['template_content'] = $this->resolveReferences($template->content ?: [], $depth + 1);
                        $block['content']['template_title'] = $template->title;
                    }
                }
            }

            // 2. Recurse into children
            if (isset($block['children']) && is_array($block['children'])) {
                $block['children'] = $this->resolveReferences($block['children'], $depth + 1);
            }

            // 3. Recurse into content if it's a block list
            if (isset($block['content']) && is_array($block['content']) && $block['type'] !== 'template_reference') {
                $isBlockList = true;
                foreach($block['content'] as $item) {
                    if (!is_array($item) || !isset($item['type'])) {
                        $isBlockList = false;
                        break;
                    }
                }
                if ($isBlockList) {
                    $block['content'] = $this->resolveReferences($block['content'], $depth + 1);
                }
            }

            return $block;
        }, $content);
    }
}
