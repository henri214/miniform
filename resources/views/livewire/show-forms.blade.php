<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Your Forms</h2>
        <a href="{{ route('forms.create') }}" class="px-4 py-2 text-black bg-blue-500 rounded hover:bg-blue-600">
            Create New Form
        </a>
    </div>

    @if ($forms->isEmpty())
        <div class="py-12 text-center rounded-lg bg-gray-50">
            <p class="text-gray-500">You haven't created any forms yet.</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($forms as $form)
                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $form->title }}</h3>
                            <p class="text-sm text-gray-500">Created {{ $form->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="deleteForm({{ $form->id }})" class="text-red-500 hover:text-red-700"
                                onclick="return confirm('Are you sure you want to delete this form?')">
                                Delete
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('form.show', ['formId' => $form->id]) }}"
                                class="text-blue-500 hover:text-blue-700">
                                View Form
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            {{ count(explode('{', $form->content)) - 2 }} fields
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
