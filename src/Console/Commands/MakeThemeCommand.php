<?php

namespace CodersFree\Laratheme\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeThemeCommand extends Command
{
    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:theme {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $viewsPath = config('theme.paths.views') . '/' . $name;
        $assetsPath = config('theme.paths.assets') . '/' . $name;

        if ($this->files->isDirectory($viewsPath)) {
            $this->error("Theme '{$name}' already exists in views!");
            return 1;
        }

        if ($this->files->isDirectory($assetsPath)) {
            $this->error("Theme '{$name}' already exists in assets!");
            return 1;
        }

        //Vistas
        $this->createViewsDirectory($viewsPath);
        
        $this->createFile($viewsPath, 'welcome.blade.php.stub', [
            'themeName' => $name
        ]);

        $this->createFile($viewsPath, 'layouts/app.blade.php.stub', [
            'themeName' => $name
        ]);

        //Assets
        $this->createAssetsDirectory($assetsPath);

        $this->createFile($assetsPath, 'css/app.css.stub', [
            'themeName' => $name
        ]);

        $this->createFile($assetsPath, 'js/app.js.stub', [
            'themeName' => $name
        ]);

        $this->info("Theme '{$name}' created successfully.");
        $this->info("Views path: {$viewsPath}");
        $this->info("Assets path: {$assetsPath}");

        return 0;
    }

    public function createViewsDirectory(string $patch)
    {
        $this->files->makeDirectory($patch, 0755, true);
        $this->files->makeDirectory("{$patch}/layouts", 0755, true);
    }

    public function createAssetsDirectory(string $patch)
    {
        $this->files->makeDirectory($patch, 0755, true);
        $this->files->makeDirectory("{$patch}/css", 0755, true);
        $this->files->makeDirectory("{$patch}/js", 0755, true);
        $this->files->makeDirectory("{$patch}/image", 0755, true);
    }

    public function createFile($directory, $stub, $data)
    {

        $patch = $this->files->exists(config('theme.paths.stubs')  . '/' . $stub)
            ? config('theme.paths.stubs') . '/' . $stub
            : __DIR__ . '/../../../stubs/' . $stub;

        $template = $this->files->get($patch);

        foreach ($data as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $stub = Str::beforeLast($stub, '.stub');

        $this->files->put("{$directory}/{$stub}", $template);
    }
}
