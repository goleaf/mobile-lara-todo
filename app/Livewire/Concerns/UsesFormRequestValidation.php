<?php

namespace App\Livewire\Concerns;

use Illuminate\Foundation\Http\FormRequest;

trait UsesFormRequestValidation
{
    protected function validateWithFormRequest(string $requestClass): array
    {
        [$request, $rules, $messages, $attributes] = $this->resolveFormRequestValidation($requestClass);

        $this->applyFormRequestHooks($request);

        return $this->validate($rules, $messages, $attributes);
    }

    protected function validateOnlyWithFormRequest(string $field, string $requestClass, array $dataOverrides = []): void
    {
        [$request, $rules, $messages, $attributes] = $this->resolveFormRequestValidation($requestClass);

        $this->applyFormRequestHooks($request);

        $this->validateOnly($field, $rules, $messages, $attributes, $dataOverrides);
    }

    /**
     * @return array{0: FormRequest, 1: array<string, mixed>, 2: array<string, string>, 3: array<string, string>}
     */
    protected function resolveFormRequestValidation(string $requestClass): array
    {
        /** @var FormRequest $request */
        $request = new $requestClass();
        $request->setContainer(app())->setRedirector(app('redirect'));

        return [
            $request,
            $request->rules(),
            $request->messages(),
            $request->attributes(),
        ];
    }

    protected function applyFormRequestHooks(FormRequest $request): void
    {
        $this->withValidator(function ($validator) use ($request): void {
            if (method_exists($request, 'withValidator')) {
                $request->withValidator($validator);
            }

            if (method_exists($request, 'after')) {
                $validator->after(
                    app()->call([$request, 'after'], ['validator' => $validator])
                );
            }
        });
    }
}
