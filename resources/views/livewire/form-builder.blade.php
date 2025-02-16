{{-- resources/views/livewire/form-builder.blade.php --}}
<div class="max-w-4xl p-6 mx-auto">
    {{-- Form Title --}}
    <div class="mb-6">
        <label for="title" class="block mb-2 font-medium text-gray-700">Form Title</label>
        <input type="text" wire:model.live="title" id="title"
            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter form title">
        @error('title')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror

        <input type="hidden" wire:model="user_id" value="{{ auth()->id() }}">
        @error('user_id')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- Toolbox --}}
    <div class="p-4 mb-6 border rounded-lg bg-gray-50">
        <h3 class="mb-6 text-sm font-medium text-gray-700">Add Form Elements</h3>
        <div class="flex flex-wrap gap-2">
            @foreach (['text' => 'Text Input', 'textarea' => 'Text Area', 'select' => 'Dropdown', 'checkbox' => 'Checkbox', 'email' => 'Email', 'number' => 'Number', 'date' => 'Date', 'tel' => 'Phone Number'] as $type => $label)
                <button type="button" wire:click="$dispatch('elementAdded', { type: '{{ $type }}' })"
                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Form Preview --}}
    <div class="p-6 mb-6 border rounded-lg">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Form Preview</h3>

        @if (empty($contents))
            <div class="p-8 text-center text-gray-500 border-2 border-dashed rounded-lg">
                Add form elements using the buttons above
            </div>
        @endif

        <div class="space-y-4">
            @foreach ($contents as $index => $element)
                <div class="p-4 transition-all border rounded-lg hover:shadow-md"
                    wire:key="element-{{ $element['id'] ?? $index }}">
                    {{-- Element Controls --}}
                    <div class="flex justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">{{ ucfirst($element['type']) }} Field</span>
                        <div class="flex gap-2">
                            <button wire:click="removeElement('{{ $element['id'] ?? '' }}')"
                                class="text-red-400 hover:text-red-600">
                                ×
                            </button>
                        </div>
                    </div>

                    {{-- Element Configuration --}}
                    <div class="grid gap-4 mb-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Field Label</label>
                            <input type="text" wire:model.live="contents.{{ $index }}.label"
                                class="w-full px-3 py-2 border rounded-md" placeholder="Enter field label">
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Placeholder</label>
                            <input type="text" wire:model.live="contents.{{ $index }}.placeholder"
                                class="w-full px-3 py-2 border rounded-md" placeholder="Enter placeholder text">
                        </div>

                        @if ($element['type'] === 'select')
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-700">Options</label>
                                <textarea wire:model.live="contents.{{ $index }}.options" class="w-full px-3 py-2 border rounded-md"
                                    placeholder="Enter options (one per line)" rows="3"></textarea>
                            </div>
                        @endif

                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model.live="contents.{{ $index }}.required"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Required</span>
                            </label>
                        </div>
                    </div>

                    {{-- Element Preview --}}
                    <div class="p-4 border rounded-md bg-gray-50">
                        <h4 class="mb-2 text-sm font-medium text-gray-500">Preview</h4>
                        @switch($element['type'])
                            @case('text')
                                <input type="text" class="w-full px-3 py-2 bg-white border rounded-md"
                                    placeholder="{{ $element['placeholder'] ?? 'Enter ' . ($element['label'] ?? 'text') }}"
                                    {{ $element['required'] ?? false ? 'required' : '' }}>
                            @break

                            @case('textarea')
                                <textarea class="w-full px-3 py-2 bg-white border rounded-md"
                                    placeholder="{{ $element['placeholder'] ?? 'Enter ' . ($element['label'] ?? 'text') }}"
                                    {{ $element['required'] ?? false ? 'required' : '' }} rows="3"></textarea>
                            @break

                            @case('select')
                                <select class="w-full p-2 border rounded">
                                    <option value="">Select {{ $element['label'] ?? '' }}</option>
                                    @if (is_array($element['options']))
                                        @foreach ($element['options'] as $option)
                                            <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                                        @endforeach
                                    @else
                                        @foreach (explode("\n", $element['options'] ?? '') as $option)
                                            <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @break

                            @case('checkbox')
                                <label class="flex items-center">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        {{ $element['required'] ?? false ? 'required' : '' }}>
                                    <span class="ml-2">{{ $element['label'] ?? 'Checkbox' }}</span>
                                </label>
                            @break

                            @case('email')
                                <input type="email" class="w-full px-3 py-2 bg-white border rounded-md"
                                    placeholder="{{ $element['placeholder'] ?? 'Enter email' }}"
                                    {{ $element['required'] ?? false ? 'required' : '' }}>
                            @break

                            @case('number')
                                <input type="number" class="w-full px-3 py-2 bg-white border rounded-md"
                                    placeholder="{{ $element['placeholder'] ?? 'Enter number' }}"
                                    {{ $element['required'] ?? false ? 'required' : '' }}>
                            @break

                            @case('date')
                                <input type="date" class="w-full px-3 py-2 bg-white border rounded-md"
                                    {{ $element['required'] ?? false ? 'required' : '' }}>
                            @break

                            @case('tel')
                                <input type="tel" class="w-full px-3 py-2 bg-white border rounded-md"
                                    {{ $element['required'] ?? false ? 'required' : '' }}>
                            @break
                        @endswitch
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Save Button --}}
    <div class="flex justify-end">
        <button wire:click="saveForm"
            class="px-6 py-2 text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            Save Form
        </button>
    </div>
</div>
