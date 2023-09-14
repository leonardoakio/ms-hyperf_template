<?php

namespace App\Controller\Utils;

use Hyperf\ViewEngine\View;
use function Hyperf\ViewEngine\view;

class DocumentationController
{
    public function html(): View
    {
        return view('documentation-swagger');
    }

    public function yaml()
    {
        return file_get_contents(BASE_PATH ."/storage/view/api-docs-v1.yaml");
    }

    public function yamlV2()
    {
        return file_get_contents(BASE_PATH ."/storage/view/api-docs-v2.yaml");
    }
}
