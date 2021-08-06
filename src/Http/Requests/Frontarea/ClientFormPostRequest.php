<?php

declare(strict_types=1);

namespace Cortex\Oauth\Http\Requests\Frontarea;

use Illuminate\Support\Str;
use Rinvex\Support\Traits\Escaper;

class ClientFormPostRequest extends ClientFormRequest
{
    use Escaper;

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $data['user_id'] = $this->user()->getAuthIdentifier();
        $data['user_type'] = $this->user()->getMorphClass();
        $this->route('client') || $data['secret'] = ((bool) $this->get('is_confidential', true)) ? Str::random(40) : null;

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $client = $this->route('client') ?? app('rinvex.oauth.client');
        $client->updateRulesUniques();

        return $client->getRules();
    }
}
