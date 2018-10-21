<?php


namespace Eliepse\WorkingGrid {

    use Eliepse\WorkingGrid\Exception\ViewNotFoundException;
    
    /**
     * @param string $viewPath
     * @param array $data
     * @return string
     * @throws ViewNotFoundException
     */
    function view(string $viewPath, array $data = []): string
    {
        preg_match("/\.([a-zA-Z0-9-_]+)$/", $viewPath, $matches);

        $view_name = $matches[1];

        $filepath = mberegi_replace("\.", DIRECTORY_SEPARATOR, $viewPath);

        if (file_exists($filepath))
            throw new ViewNotFoundException($view_name, $viewPath);

        ob_start() && extract($data);

        /** @noinspection PhpIncludeInspection */
        require resources_path("views/$filepath.php");

        return ob_get_clean();

    }

    function base_path(string $path = ""): string
    {
        return (__DIR__ . "/../$path");
    }

    function resources_path(string $path = ""): string
    {
        return base_path("resources/$path");
    }

    if (!function_exists("array_contains")) {
        /**
         * Check if an array contains an item at least once
         * @param $array
         * @param $item
         * @return bool
         */
        function array_contains($array, $item): bool
        {
            return boolval(count(array_keys($array, $item, true)));
        }
    }

}