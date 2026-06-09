<div class="mx-auto w-full max-w-4xl">
    @if($submitted)
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <flux:icon name="check-badge" variant="solid" class="mb-4 size-16 text-emerald-500" />
            <flux:heading size="xl" class="mb-2">Application Submitted Successfully!</flux:heading>
            <flux:text class="mb-8 max-w-md">Thank you for your interest. We have received your application and will review it. You will be contacted regarding next steps.</flux:text>
            <flux:button href="/" variant="primary">Submit Another Application</flux:button>
        </div>
    @else
        <div class="mb-8 text-center">
            <flux:heading size="xl" class="mb-2">Application Form</flux:heading>
            <flux:text>Please fill out all required fields marked with <span class="text-red-500">*</span></flux:text>
        </div>

        <form wire:submit="submit" class="space-y-8">
            @foreach($this->groupedFields as $section => $fields)
                <flux:card class="p-6">
                    <flux:heading class="mb-6">{{ $section }}</flux:heading>

                    <div class="space-y-5">
                        @foreach($fields as $field)
                            @php
                                $wireKey = $field->type === 'consent' ? "consent.{$field->key}" : "formData.{$field->key}";
                                $errorKey = $field->type === 'consent' ? "consent.{$field->key}" : "formData.{$field->key}";
                            @endphp

                            <div wire:key="field-{{ $field->key }}">
                                @switch($field->type)
                                    @case('text')
                                    @case('email')
                                    @case('tel')
                                    @case('url')
                                        <flux:field>
                                            <flux:label>{{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif</flux:label>
                                            @if($field->description)
                                                <flux:description>{{ $field->description }}</flux:description>
                                            @endif
                                            <flux:input
                                                type="{{ $field->type === 'url' ? 'url' : ($field->type === 'tel' ? 'tel' : ($field->type === 'email' ? 'email' : 'text')) }}"
                                                wire:model="{{ $wireKey }}"
                                                placeholder="{{ $field->placeholder }}"
                                            />
                                            <flux:error name="{{ $errorKey }}" />
                                        </flux:field>
                                        @break

                                    @case('textarea')
                                        <flux:field>
                                            <flux:label>{{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif</flux:label>
                                            @if($field->description)
                                                <flux:description>{{ $field->description }}</flux:description>
                                            @endif
                                            <textarea
                                                wire:model="{{ $wireKey }}"
                                                placeholder="{{ $field->placeholder }}"
                                                rows="4"
                                                class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm placeholder-neutral-400 focus:border-accent focus:ring-2 focus:ring-accent/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white"
                                            ></textarea>
                                            <flux:error name="{{ $errorKey }}" />
                                        </flux:field>
                                        @break

                                    @case('date')
                                        <flux:field>
                                            <flux:label>{{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif</flux:label>
                                            <flux:input
                                                type="date"
                                                wire:model="{{ $wireKey }}"
                                                placeholder="{{ $field->placeholder }}"
                                            />
                                            <flux:error name="{{ $errorKey }}" />
                                        </flux:field>
                                        @break

                                    @case('select')
                                        <flux:field>
                                            <flux:label>{{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif</flux:label>
                                            <flux:select wire:model="{{ $wireKey }}">
                                                <option value="">Select...</option>
                                                @foreach($field->options ?? [] as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </flux:select>
                                            <flux:error name="{{ $errorKey }}" />
                                        </flux:field>
                                        @break

                                    @case('radio')
                                        <flux:field>
                                            <flux:label>{{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif</flux:label>
                                            @if($field->description)
                                                <flux:description>{{ $field->description }}</flux:description>
                                            @endif
                                            <div class="flex flex-wrap gap-4">
                                                @foreach($field->options ?? [] as $option)
                                                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                                                        <input
                                                            type="radio"
                                                            wire:model="{{ $wireKey }}"
                                                            value="{{ $option }}"
                                                            class="size-4 accent-accent"
                                                        >
                                                        {{ $option }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <flux:error name="{{ $errorKey }}" />
                                        </flux:field>
                                        @break

                                    @case('checkbox')
                                        <flux:field>
                                            <flux:label>{{ $field->label }}</flux:label>
                                            @if($field->description)
                                                <flux:description>{{ $field->description }}</flux:description>
                                            @endif
                                            <div class="flex flex-wrap gap-4">
                                                @foreach($field->options ?? [] as $option)
                                                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                                                        <input
                                                            type="checkbox"
                                                            wire:model="{{ $wireKey }}"
                                                            value="{{ $option }}"
                                                            class="size-4 rounded accent-accent"
                                                        >
                                                        {{ $option }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </flux:field>
                                        @break

                                    @case('consent')
                                        <flux:field>
                                            <label class="flex items-start gap-3 cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    wire:model="{{ $wireKey }}"
                                                    class="mt-0.5 size-4 rounded accent-accent"
                                                >
                                                <div>
                                                    <flux:label>{{ $field->label }} @if($field->required)<span class="text-red-500">*</span>@endif</flux:label>
                                                    @if($field->description)
                                                        <flux:text variant="subtle" class="text-sm">{{ $field->description }}</flux:text>
                                                    @endif
                                                </div>
                                            </label>
                                            <flux:error name="{{ $errorKey }}" />
                                        </flux:field>
                                        @break
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </flux:card>
            @endforeach

            <div class="flex justify-center pb-12">
                <flux:button type="submit" variant="primary" class="w-full max-w-md h-12 text-base">
                    Submit Application
                </flux:button>
            </div>
        </form>
    @endif
</div>
