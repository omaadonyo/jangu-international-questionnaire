<div class="flex h-full w-full flex-1 flex-col gap-6">
    {{-- Tabs --}}
    <div class="flex gap-1 border-b border-neutral-200 dark:border-neutral-700">
        <button wire:click="switchTab('responses')" class="px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px {{ $activeTab === 'responses' ? 'border-accent text-accent' : 'border-transparent text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300' }}">
            Responses
        </button>
        <button wire:click="switchTab('fields')" class="px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px {{ $activeTab === 'fields' ? 'border-accent text-accent' : 'border-transparent text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300' }}">
            Form Fields
        </button>
    </div>

    @if($activeTab === 'responses')
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 pointer-events-none"></div>
                <div class="flex items-center gap-3 relative">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg shadow-emerald-500/20">
                        <flux:icon name="document-text" variant="solid" class="size-5 text-white" />
                    </div>
                    <div>
                        <flux:text variant="subtle" class="text-sm">Total Responses</flux:text>
                        <flux:heading size="xl" class="text-emerald-600 dark:text-emerald-400">{{ $this->stats['total'] }}</flux:heading>
                    </div>
                </div>
            </flux:card>
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-yellow-600/5 pointer-events-none"></div>
                <div class="flex items-center gap-3 relative">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 shadow-lg shadow-yellow-500/20">
                        <flux:icon name="clock" variant="solid" class="size-5 text-white" />
                    </div>
                    <div>
                        <flux:text variant="subtle" class="text-sm">Pending Review</flux:text>
                        <flux:heading size="xl" class="text-yellow-600 dark:text-yellow-400">{{ $this->stats['pending'] }}</flux:heading>
                    </div>
                </div>
            </flux:card>
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-blue-600/5 pointer-events-none"></div>
                <div class="flex items-center gap-3 relative">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/20">
                        <flux:icon name="arrow-trending-up" variant="solid" class="size-5 text-white" />
                    </div>
                    <div>
                        <flux:text variant="subtle" class="text-sm">This Week</flux:text>
                        <flux:heading size="xl" class="text-blue-600 dark:text-blue-400">{{ $this->stats['recent'] }}</flux:heading>
                    </div>
                </div>
            </flux:card>
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-500/10 to-violet-600/5 pointer-events-none"></div>
                <div class="flex items-center gap-3 relative">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 shadow-lg shadow-violet-500/20">
                        <flux:icon name="users" variant="solid" class="size-5 text-white" />
                    </div>
                    <div>
                        <flux:text variant="subtle" class="text-sm">Male / Female</flux:text>
                        <flux:heading size="xl" class="text-violet-600 dark:text-violet-400">{{ $this->stats['gender']['Male'] ?? 0 }} / {{ $this->stats['gender']['Female'] ?? 0 }}</flux:heading>
                    </div>
                </div>
            </flux:card>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 size-32 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex size-8 items-center justify-center rounded-lg bg-emerald-500/10">
                            <flux:icon name="academic-cap" variant="solid" class="size-4 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <flux:heading>Education Level</flux:heading>
                    </div>
                    <div class="space-y-2">
                        @forelse($this->stats['education'] as $level => $count)
                            @php $pct = $this->stats['total'] > 0 ? round(($count / $this->stats['total']) * 100) : 0; @endphp
                            <div>
                                <div class="mb-1 flex items-center justify-between text-sm">
                                    <flux:text variant="strong" class="capitalize">{{ $level ?: 'Not specified' }}</flux:text>
                                    <flux:text variant="subtle">{{ $count }} ({{ $pct }}%)</flux:text>
                                </div>
                                <div class="h-2.5 w-full overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400 transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <flux:text variant="subtle">No data</flux:text>
                        @endforelse
                    </div>
                </div>
            </flux:card>
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 size-32 bg-pink-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex size-8 items-center justify-center rounded-lg bg-pink-500/10">
                            <flux:icon name="user-group" variant="solid" class="size-4 text-pink-600 dark:text-pink-400" />
                        </div>
                        <flux:heading>Gender Distribution</flux:heading>
                    </div>
                    <div class="space-y-2">
                        @forelse($this->stats['gender'] as $gender => $count)
                            @php
                                $pct = $this->stats['total'] > 0 ? round(($count / $this->stats['total']) * 100) : 0;
                                $barColors = ['Male' => 'from-blue-500 to-blue-400', 'Female' => 'from-pink-500 to-pink-400'];
                                $bgColors = ['Male' => 'bg-blue-100 dark:bg-blue-900/30', 'Female' => 'bg-pink-100 dark:bg-pink-900/30'];
                            @endphp
                            <div>
                                <div class="mb-1 flex items-center justify-between text-sm">
                                    <flux:text variant="strong">{{ $gender ?: 'Not specified' }}</flux:text>
                                    <flux:text variant="subtle">{{ $count }} ({{ $pct }}%)</flux:text>
                                </div>
                                <div class="h-2.5 w-full overflow-hidden rounded-full {{ $bgColors[$gender] ?? 'bg-neutral-200 dark:bg-neutral-700' }}">
                                    <div class="h-full rounded-full bg-gradient-to-r {{ $barColors[$gender] ?? 'from-accent to-accent' }} transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <flux:text variant="subtle">No data</flux:text>
                        @endforelse
                    </div>
                </div>
            </flux:card>
            <flux:card class="p-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 size-32 bg-violet-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex size-8 items-center justify-center rounded-lg bg-violet-500/10">
                            <flux:icon name="megaphone" variant="solid" class="size-4 text-violet-600 dark:text-violet-400" />
                        </div>
                        <flux:heading>How They Heard</flux:heading>
                    </div>
                    <div class="space-y-2">
                        @forelse($this->stats['hear_about'] as $source => $count)
                            @php $pct = $this->stats['total'] > 0 ? round(($count / $this->stats['total']) * 100) : 0; @endphp
                            <div>
                                <div class="mb-1 flex items-center justify-between text-sm">
                                    <flux:text variant="strong" class="capitalize">{{ $source ?: 'Not specified' }}</flux:text>
                                    <flux:text variant="subtle">{{ $count }} ({{ $pct }}%)</flux:text>
                                </div>
                                <div class="h-2.5 w-full overflow-hidden rounded-full bg-violet-100 dark:bg-violet-900/30">
                                    <div class="h-full rounded-full bg-gradient-to-r from-violet-500 to-violet-400 transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <flux:text variant="subtle">No data</flux:text>
                        @endforelse
                    </div>
                </div>
            </flux:card>
        </div>

        {{-- Toolbar --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-1 items-center gap-3">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Search responses..." class="max-w-xs" />
                <flux:select wire:model.live="statusFilter" class="max-w-[160px]">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </flux:select>
            </div>
            <div class="flex items-center gap-2">
                <flux:button wire:click="exportExcel" icon="arrow-down-tray" variant="outline">Excel</flux:button>
                <flux:button wire:click="exportPdf" icon="arrow-down-tray" variant="outline">PDF</flux:button>
            </div>
        </div>

        {{-- Table --}}
        <flux:table :paginate="$this->submissions" container:class="max-h-[600px]">
            <flux:table.columns sticky>
                <flux:table.column sortable :sorted="$sortField === 'id'" :direction="$sortField === 'id' ? $sortDirection : ''" wire:click="sortBy('id')" align="start" class="w-16">#</flux:table.column>
                <flux:table.column sortable :sorted="$sortField === 'first_name'" :direction="$sortField === 'first_name' ? $sortDirection : ''" wire:click="sortBy('first_name')">Name</flux:table.column>
                <flux:table.column sortable :sorted="$sortField === 'email'" :direction="$sortField === 'email' ? $sortDirection : ''" wire:click="sortBy('email')">Email</flux:table.column>
                <flux:table.column>Gender</flux:table.column>
                <flux:table.column>Education</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column sortable :sorted="$sortField === 'created_at'" :direction="$sortField === 'created_at' ? $sortDirection : ''" wire:click="sortBy('created_at')">Submitted</flux:table.column>
                <flux:table.column align="end">Actions</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse($this->submissions as $submission)
                    <flux:table.row :key="$submission->id" class="cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800/50" wire:click="viewSubmission({{ $submission->id }})">
                        <flux:table.cell variant="strong">{{ $submission->id }}</flux:table.cell>
                        <flux:table.cell>{{ $submission->first_name ?: 'N/A' }}</flux:table.cell>
                        <flux:table.cell>{{ $submission->email ?: 'N/A' }}</flux:table.cell>
                        <flux:table.cell>{{ $submission->data['gender'] ?? '—' }}</flux:table.cell>
                        <flux:table.cell class="max-w-[140px] truncate">{{ $submission->data['education_level'] ?? '—' }}</flux:table.cell>
                        <flux:table.cell>
                            @php
                                $statusColors = ['pending' => 'yellow', 'reviewed' => 'blue', 'accepted' => 'emerald', 'rejected' => 'red'];
                            @endphp
                            <flux:badge :color="$statusColors[$submission->status] ?? 'gray'" variant="solid" size="sm">{{ ucfirst($submission->status) }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $submission->created_at->format('d M Y') }}</flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:button size="sm" variant="ghost" icon="eye" wire:click.stop="viewSubmission({{ $submission->id }})" />
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="8">
                            <div class="flex flex-col items-center justify-center py-12">
                                <flux:icon name="inbox" variant="outline" class="mb-2 size-8 text-neutral-400" />
                                <flux:text variant="subtle">No submissions found</flux:text>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Submission Detail Modal --}}
        <flux:modal name="submission-detail" wire:model.self="showSubmissionDetail" class="min-w-[600px] max-w-3xl">
            @if($selectedSubmission)
                <div class="space-y-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <flux:heading size="lg">Submission #{{ $selectedSubmission->id }}</flux:heading>
                            <flux:text variant="subtle">{{ $selectedSubmission->created_at->format('d M Y, H:i') }}</flux:text>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:select wire:change="updateStatus({{ $selectedSubmission->id }}, $event.target.value)" class="max-w-[140px]">
                                <option value="pending" @selected($selectedSubmission->status === 'pending')>Pending</option>
                                <option value="reviewed" @selected($selectedSubmission->status === 'reviewed')>Reviewed</option>
                                <option value="accepted" @selected($selectedSubmission->status === 'accepted')>Accepted</option>
                                <option value="rejected" @selected($selectedSubmission->status === 'rejected')>Rejected</option>
                            </flux:select>
                            <flux:button variant="ghost" icon="pencil-square" wire:click="toggleEditSubmission" />
                            <flux:modal.close>
                                <flux:button variant="ghost" icon="x-mark" size="sm" />
                            </flux:modal.close>
                        </div>
                    </div>

                    <flux:separator />

                    @if($editingSubmission)
                        <div class="space-y-4">
                            @php $fields = \App\Models\FormField::where('active', true)->whereNotIn('type', ['section_header', 'consent'])->orderBy('sort_order')->get(); @endphp
                            @foreach($fields as $field)
                                <flux:field>
                                    <flux:label>{{ $field->label }}</flux:label>
                                    @if(in_array($field->type, ['text', 'email', 'tel', 'url']))
                                        <flux:input type="{{ $field->type === 'url' ? 'url' : ($field->type === 'tel' ? 'tel' : ($field->type === 'email' ? 'email' : 'text')) }}" wire:model="selectedSubmission.data.{{ $field->key }}" />
                                    @elseif($field->type === 'textarea')
                                        <textarea wire:model="selectedSubmission.data.{{ $field->key }}" rows="3" class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-800"></textarea>
                                    @elseif($field->type === 'date')
                                        <flux:input type="date" wire:model="selectedSubmission.data.{{ $field->key }}" />
                                    @elseif($field->type === 'select')
                                        <flux:select wire:model="selectedSubmission.data.{{ $field->key }}">
                                            <option value="">Select...</option>
                                            @foreach($field->options ?? [] as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </flux:select>
                                    @elseif(in_array($field->type, ['radio', 'checkbox']))
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($field->options ?? [] as $opt)
                                                <label class="flex items-center gap-2 text-sm">
                                                    <input type="{{ $field->type }}" wire:model="selectedSubmission.data.{{ $field->key }}" value="{{ $opt }}" class="size-4 accent-accent">
                                                    {{ $opt }}
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </flux:field>
                            @endforeach
                            <div class="flex justify-end gap-2 pt-4">
                                <flux:button variant="ghost" wire:click="toggleEditSubmission">Cancel</flux:button>
                                <flux:button variant="primary" wire:click="saveSubmission">Save Changes</flux:button>
                            </div>
                        </div>
                    @else
                        {{-- Personal Information --}}
                        <div>
                            <flux:heading class="mb-3">Personal Information</flux:heading>
                            <dl class="grid grid-cols-2 gap-3 text-sm">
                                @foreach(['first_name'=>'First Name','middle_name'=>'Middle Name','last_name'=>'Last Name','email'=>'Email','phone'=>'Phone','date_of_birth'=>'Date of Birth','gender'=>'Gender','nin'=>'NIN','district'=>'District','county'=>'County','sub_county'=>'Sub-County','village'=>'Village','education_level'=>'Education Level','education_other'=>'Education (Other)','tiktok'=>'TikTok'] as $key => $label)
                                    <div>
                                        <dt class="font-medium text-neutral-500 dark:text-neutral-400">{{ $label }}</dt>
                                        <dd>{{ $selectedSubmission->data[$key] ?? '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>

                        <flux:separator />

                        {{-- Emergency Contact --}}
                        <div>
                            <flux:heading class="mb-3">Emergency Contact</flux:heading>
                            <dl class="grid grid-cols-2 gap-3 text-sm">
                                @foreach(['next_of_kin_name'=>'Next of Kin','next_of_kin_relationship'=>'Relationship','next_of_kin_phone'=>'Contact Number','next_of_kin_nin'=>'NIN'] as $key => $label)
                                    <div>
                                        <dt class="font-medium text-neutral-500 dark:text-neutral-400">{{ $label }}</dt>
                                        <dd>{{ $selectedSubmission->data[$key] ?? '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>

                        <flux:separator />

                        {{-- Motivation --}}
                        <div>
                            <flux:heading class="mb-3">Motivation</flux:heading>
                            <dl class="grid grid-cols-2 gap-3 text-sm">
                                @foreach(['hear_about'=>'How did you hear?','hear_about_other'=>'Other source','recommender'=>'Recommender','applied_before'=>'Applied Before','applied_times'=>'Times Applied','time_commitment'=>'Time Commitment','previous_programs'=>'Previous Programs'] as $key => $label)
                                    <div>
                                        <dt class="font-medium text-neutral-500 dark:text-neutral-400">{{ $label }}</dt>
                                        <dd>{{ $selectedSubmission->data[$key] ?? '—' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>

                        {{-- Text Responses --}}
                        <div class="space-y-4">
                            @foreach(['personal_statement'=>'Personal Statement','business_description'=>'Business Description','skills_talents'=>'Skills & Talents'] as $key => $label)
                                <div>
                                    <flux:heading class="mb-1">{{ $label }}</flux:heading>
                                    <div class="max-h-32 overflow-y-auto rounded-lg border border-neutral-200 bg-neutral-50 p-3 text-sm dark:border-neutral-700 dark:bg-neutral-800/50">
                                        {{ $selectedSubmission->data[$key] ?? '—' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!$editingSubmission)
                        <flux:separator />
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <flux:icon name="check-badge" variant="solid" class="size-4 text-emerald-500" />
                                <flux:text variant="strong">Consents</flux:text>
                                <flux:text variant="subtle" class="text-xs">
                                    {{ isset($selectedSubmission->data['consent_1']) ? '✓ Consent 1' : '' }}
                                    {{ isset($selectedSubmission->data['consent_2']) ? '✓ Consent 2' : '' }}
                                </flux:text>
                            </div>
                            <flux:button variant="danger" size="sm" wire:click="deleteSubmission({{ $selectedSubmission->id }})" wire:confirm="Delete this submission?" icon="trash">Delete</flux:button>
                        </div>
                    @endif
                </div>
            @endif
        </flux:modal>

    @elseif($activeTab === 'fields')
        {{-- Form Fields Management --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>Form Fields</flux:heading>
                <flux:text variant="subtle">Manage the fields displayed on the application form.</flux:text>
            </div>
            <flux:button wire:click="createField" variant="primary" icon="plus">Add Field</flux:button>
        </div>

        <flux:table container:class="max-h-[600px]">
            <flux:table.columns sticky>
                <flux:table.column align="start" class="w-12">Order</flux:table.column>
                <flux:table.column>Key</flux:table.column>
                <flux:table.column>Label</flux:table.column>
                <flux:table.column>Type</flux:table.column>
                <flux:table.column>Section</flux:table.column>
                <flux:table.column>Required</flux:table.column>
                <flux:table.column>Active</flux:table.column>
                <flux:table.column align="end" class="w-32">Actions</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse($this->formFields as $field)
                    <flux:table.row :key="$field->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-1">
                                <flux:button size="xs" variant="ghost" icon="chevron-up" wire:click="moveFieldUp({{ $field->id }})" />
                                <span class="text-xs tabular-nums">{{ $field->sort_order }}</span>
                                <flux:button size="xs" variant="ghost" icon="chevron-down" wire:click="moveFieldDown({{ $field->id }})" />
                            </div>
                        </flux:table.cell>
                        <flux:table.cell><code class="rounded bg-neutral-100 px-1.5 py-0.5 text-xs dark:bg-neutral-800">{{ $field->key }}</code></flux:table.cell>
                        <flux:table.cell class="max-w-[200px] truncate">{{ $field->label }}</flux:table.cell>
                        <flux:table.cell><flux:badge size="sm" variant="solid" color="{{ $field->type === 'section_header' ? 'purple' : ($field->type === 'consent' ? 'orange' : 'blue') }}">{{ $field->type }}</flux:badge></flux:table.cell>
                        <flux:table.cell class="capitalize">{{ $field->section ?: '—' }}</flux:table.cell>
                        <flux:table.cell>
                            @if($field->type !== 'section_header')
                                <flux:icon name="{{ $field->required ? 'check-circle' : 'x-circle' }}" variant="solid" class="size-4 {{ $field->required ? 'text-emerald-500' : 'text-neutral-300' }}" />
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:switch wire:click="toggleFieldActive({{ $field->id }})" :checked="$field->active" />
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex items-center gap-1">
                                <flux:button size="xs" variant="ghost" icon="pencil-square" wire:click="editField({{ $field->id }})" />
                                @if(!in_array($field->type, ['section_header']))
                                    <flux:button size="xs" variant="ghost" icon="trash" wire:click="deleteField({{ $field->id }})" wire:confirm="Delete this field?" class="text-red-500 hover:text-red-700" />
                                @endif
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="8">
                            <div class="flex flex-col items-center justify-center py-12">
                                <flux:icon name="inbox" variant="outline" class="mb-2 size-8 text-neutral-400" />
                                <flux:text variant="subtle">No fields defined yet</flux:text>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Field Form Modal --}}
        <flux:modal name="field-form" wire:model.self="showFieldForm" class="max-w-lg">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg">{{ $editingField ? 'Edit Field' : 'Add Field' }}</flux:heading>
                    <flux:modal.close>
                        <flux:button variant="ghost" icon="x-mark" size="sm" />
                    </flux:modal.close>
                </div>

                <flux:separator />

                <div class="space-y-4">
                    <flux:input wire:model="fieldKey" label="Field Key" placeholder="e.g. first_name" />
                    <flux:input wire:model="fieldLabel" label="Label" placeholder="e.g. First Name" />
                    <flux:select wire:model="fieldType" label="Type">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="email">Email</option>
                        <option value="tel">Phone</option>
                        <option value="url">URL</option>
                        <option value="date">Date</option>
                        <option value="select">Select</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="section_header">Section Header</option>
                        <option value="consent">Consent</option>
                    </flux:select>
                    <flux:input wire:model="fieldPlaceholder" label="Placeholder" />
                    <flux:textarea wire:model="fieldDescription" label="Description" rows="2" />
                    <flux:input wire:model="fieldSection" label="Section" placeholder="e.g. personal" />
                    @if(in_array($fieldType, ['select', 'radio', 'checkbox']))
                        <flux:textarea wire:model="fieldOptions" label="Options (one per line)" rows="4" placeholder="Option 1&#10;Option 2&#10;Option 3" />
                    @endif
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model="fieldRequired" class="size-4 rounded accent-accent">
                            Required
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model="fieldActive" class="size-4 rounded accent-accent">
                            Active
                        </label>
                    </div>
                    <flux:input wire:model="fieldSortOrder" label="Sort Order" type="number" />
                </div>

                <flux:separator />

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" wire:click="saveField">
                        {{ $editingField ? 'Update' : 'Create' }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
