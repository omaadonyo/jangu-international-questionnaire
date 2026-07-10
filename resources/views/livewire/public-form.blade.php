<div>
    @if($submitted)
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-secondary/20 mb-6">
                <flux:icon name="check-badge" variant="solid" class="size-10 text-secondary" />
            </div>
            <h3 class="text-2xl font-bold text-primary">Application Submitted!</h3>
            <p class="mt-3 text-primary/60 max-w-md">Thank you for your interest in Jangu International. We have received your application and will review it. You will be contacted regarding next steps.</p>
            <flux:button href="/" variant="primary" class="mt-8">Submit Another Application</flux:button>
        </div>
    @else
        {{-- Progress Bar --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                @foreach($this->sectionKeys as $stepIndex => $section)
                    <button type="button" wire:click="goToStep({{ $stepIndex }})" class="flex flex-col items-center gap-1 group {{ $stepIndex <= $currentStep ? 'cursor-pointer' : 'cursor-default' }}" {{ $stepIndex > $currentStep + 1 ? 'disabled' : '' }}>
                        <span class="flex size-9 items-center justify-center rounded-full text-sm font-semibold transition-all duration-300 {{ $stepIndex < $currentStep ? 'bg-secondary text-primary' : ($stepIndex === $currentStep ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-primary/10 text-primary/40') }}">
                            @if($stepIndex < $currentStep)
                                <flux:icon name="check" class="size-4" />
                            @else
                                {{ $stepIndex + 1 }}
                            @endif
                        </span>
                        <span class="text-xs font-medium {{ $stepIndex === $currentStep ? 'text-primary' : 'text-primary/40' }} hidden sm:block">{{ $section }}</span>
                    </button>
                @endforeach
            </div>
            <div class="relative h-2 w-full overflow-hidden rounded-full bg-primary/10">
                <div class="h-full rounded-full bg-secondary transition-all duration-500 ease-out" style="width: {{ $this->progressPercent }}%"></div>
            </div>
        </div>

        <form wire:submit="submit">
            {{-- Current Step Fields --}}
            <div class="rounded-2xl border border-primary/10 bg-white p-6 sm:p-8 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-primary">{{ $this->currentSection }}</h3>
                    <p class="mt-1 text-sm text-primary/60">Please fill in the information below</p>
                </div>

                <div class="space-y-5">
                    @php $currentFields = $this->groupedFields[$this->currentSection] ?? []; @endphp
                    @foreach($currentFields as $field)
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
                                            class="block w-full rounded-xl border border-primary/20 bg-white px-4 py-2.5 text-sm placeholder-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"
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
                                                        class="size-4 accent-primary"
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
                                                        class="size-4 rounded accent-primary"
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
                                                class="mt-0.5 size-4 rounded accent-primary"
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
            </div>

            {{-- Navigation Buttons --}}
            <div class="mt-6 flex items-center justify-between">
                <div>
                    @if($currentStep > 0)
                        <flux:button type="button" variant="ghost" wire:click="prevStep" class="text-primary hover:bg-primary/5">
                            <flux:icon name="arrow-left" class="size-4" /> Previous
                        </flux:button>
                    @endif
                </div>
                <div>
                    @php $isLastStep = $currentStep === count($this->sectionKeys) - 1; @endphp
                    @if($isLastStep)
                        <flux:button type="submit" variant="primary" class="bg-primary hover:bg-primary-600">
                            Submit Application
                        </flux:button>
                    @else
                        <flux:button type="button" variant="primary" wire:click="nextStep" class="bg-primary hover:bg-primary-600">
                            Next <flux:icon name="arrow-right" class="size-4" />
                        </flux:button>
                    @endif
                </div>
            </div>
        </form>
    @endif
</div>
