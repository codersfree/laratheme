<?php

namespace CodersFree\Laratheme\Services;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\View\Factory;
use Illuminate\Support\Str;

class ThemeService
{
    protected Factory $view;
    protected UrlGenerator $url;

    public function __construct(Factory $view, UrlGenerator $url)
    {
        $this->view = $view;
        $this->url = $url;
    }

    public function getActiveTheme(): string
    {
        return config('theme.active');
    }

    public function view(string $view, array $data = [])
    {
        $view = "theme::{$view}";
        return $this->view->make($view, $data);
    }

    public function asset(string $path): string
    {

        $activeTheme = $this->getActiveTheme();
        $assetsPath = config('theme.paths.assets');

        //'public/themes'
        $path = "{$assetsPath}/{$activeTheme}/" . ltrim($path, '/');
        $path = str_replace('public/', '', $path);


        $relativePath = Str::after($path, public_path() . DIRECTORY_SEPARATOR);

        return $this->url->asset($relativePath);
    }
}