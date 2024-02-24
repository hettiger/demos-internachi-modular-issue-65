<?php

namespace Modules\MyModule\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;

class MyModuleServiceProvider extends ServiceProvider
{
	public function register()
	{
	}

	public function boot()
	{
        $this->callAfterResolving('translator', function ($translator) {
            if (!($translator instanceof Translator)) {
                return;
            }

            foreach (File::directories(__DIR__.'/../../resources/lang/') as $directory) {
                $locale = basename($directory);
                $packageValidationLines = collect(Arr::dot(trans("my-module::validation", locale: $locale)))
                    ->mapWithKeys(fn($value, $key) => ["validation.$key" => $value])
                    ->toArray();

                if (empty($packageValidationLines)) { continue; }

                $translator->addLines($packageValidationLines, $locale);
            }
        });
	}
}
