<?php

namespace App\Models;

use Awcodes\Curator\Models\Media as CuratorMedia;

class Media extends CuratorMedia
{
    /**
     * Override to bypass Glide and prevent Nginx 404 errors for dynamic image routes.
     */
    public function getSignedUrl(array $params = []): string
    {
        return $this->url;
    }
}
