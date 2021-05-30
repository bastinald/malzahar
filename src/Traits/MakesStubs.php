<?php

namespace Bastinald\Malzahar\Traits;

use Illuminate\Filesystem\Filesystem;

trait MakesStubs
{
    /**
     * Make and save a stub.
     *
     * @param  string $path
     * @param  string $stub
     * @param  array $replaces
     * @return void
     */
    public function makeStub(string $path, string $stub, array $replaces): void
    {
        $filesystem = new Filesystem;
        $contents = $filesystem->get(__DIR__ . '/../../resources/stubs/' . $stub);

        foreach ($replaces as $search => $replace) {
            $contents = str_replace($search, $replace, $contents);
        }

        $filesystem->ensureDirectoryExists(dirname($path));
        $filesystem->put($path, $contents);
    }
}
