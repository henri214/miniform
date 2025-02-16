<div class="max-w-4xl p-6 mx-auto">
    <h1 class="pl-5 text-[40px] font-bold text-center text-black">{{ $form->title }}</h1>
    <form class="space-y-4">
        @foreach ($form->getContent() as $contentValues)
            {{-- @foreach ($contentValues as $field => $fieldValue) --}}
            <div class="p-4 border rounded">
                <label class="block mb-2 font-medium">
                    {{ ucfirst($contentValues['type']) }}
                    @if ($contentValues['required'])
                        <span class="text-red-500">*</span>
                    @endif
                </label>

                <!-- Render Fields Based on Type -->

                @switch($contentValues['type'])
                    @case('text')
                        <input type="text" name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded"
                            placeholder="{{ $contentValues['placeholder'] ?? '' }}" minlength="2" maxlength="255"
                            @if ($contentValues['required']) required @endif>
                    @break

                    @case('email')
                        <input type="email" name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                            placeholder="{{ $contentValues['placeholder'] ?? '' }}"
                            @if ($contentValues['required']) required @endif>
                    @break

                    @case('tel')
                        <input type="tel" name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded"
                            placeholder="{{ $contentValues['placeholder'] ?? '' }}"
                            @if ($contentValues['required']) required @endif>
                    @break

                    @case('date')
                        <input type="date" name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded"
                            placeholder="{{ $contentValues['placeholder'] ?? '' }}"
                            @if ($contentValues['required']) required @endif>
                    @break

                    @case('textarea')
                        <textarea name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded" minlength="2" maxlength="1000"
                            rows="4" placeholder="{{ $contentValues['placeholder'] ?? '' }}"
                            @if ($contentValues['required']) required @endif></textarea>
                    @break

                    @case('number')
                        <textarea name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="{{ $contentValues['placeholder'] ?? '' }}"
                            @if ($contentValues['required']) required @endif></textarea>
                    @break

                    @case('select')
                        <select name="{{ $contentValues['type'] }}" class="w-full p-2 border rounded"
                            @if ($contentValues['required']) required @endif>
                            <option value="">Select an option</option>
                            @foreach (explode("\n", $contentValues['options']) as $option)
                                <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                            @endforeach
                        </select>
                    @break

                    @case('checkbox')
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="{{ $contentValues['type'] }}"
                                @if ($contentValues['required']) required @endif>
                            <span>{{ $contentValues['label'] }}</span>
                        </div>
                    @break
                @endswitch
            </div>
            {{-- @endforeach --}}
        @endforeach

        <!-- Submit Button (Optional) -->
        <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded">
            Submit Form
        </button>
    </form>
</div>
