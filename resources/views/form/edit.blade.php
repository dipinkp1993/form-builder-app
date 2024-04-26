<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container mx-auto">
                        <div class="flex justify-center">
                            <div class="w-full md:w-8/12 lg:w-6/12">
                                <div class="bg-white rounded-lg shadow-lg">
                                    <div class="bg-gray-200 text-gray-800 font-bold text-lg p-3">
                                        Edit Form
                                    </div>

                                    <div class="p-6">
                                        @if (session('success'))
                                            <div class="bg-green-200 text-green-800 rounded-lg p-3 mb-3">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="bg-red-200 text-red-800 rounded-lg p-3 mb-3">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('forms.update', $form->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4">
                                                <label for="name" class="block text-gray-700 font-bold mb-2">Form Name</label>
                                                <input type="text" name="name" id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm form-name" value="{{ $form->name }}" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                                                <textarea name="description" id="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $form->description }}</textarea>
                                            </div>

                                            <div id="fields-container">
                                                <label class="block text-gray-700 font-bold mb-2">Form Fields</label>
                                                @foreach($form->fields as $index => $field)
                                                <div class="form-group field field-template mb-4">
                                                    <input type="text" name="fields[{{ $index }}][id]" value="{{ $field->id }}" hidden>
                                                    <input type="text" name="fields[{{ $index }}][label]" placeholder="Label" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $field->label }}" required>
                                                    <input type="text" name="fields[{{ $index }}][name]" placeholder="Name Attribute" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $field->name }}" readonly required>
                                                    <select name="fields[{{ $index }}][type]" class="form-select field-type" required>
                                                        <option value="text" {{ $field->type === 'text' ? 'selected' : '' }}>Text</option>
                                                        <option value="email" {{ $field->type === 'email' ? 'selected' : '' }}>Email</option>
                                                        <option value="number" {{ $field->type === 'number' ? 'selected' : '' }}>Number</option>
                                                        <option value="select" {{ $field->type === 'select' ? 'selected' : '' }}>Select</option>
                                                        <!-- Add other field types as needed -->
                                                    </select>
                                                    <div class="options-container" style="{{ $field->type === 'select' ? 'display:block' : 'display:none' }}">
                                                        <input type="text" name="fields[{{ $index }}][options][]" placeholder="Option" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm option-field" value="{{ implode(',', json_decode($field->options)) }}"><br>(<small>*Note:Add comma seperated options</small>)
                                                    </div>

                                                    <button type="button" class="remove-field ml-2 px-2 py-1 bg-red-500 text-red rounded">Remove</button>
                                                </div>
                                                @endforeach
                                            </div>

                                            <div class="flex justify-between mt-4">
                                                <x-primary-button id="add-field">{{ __('Add Field') }}</x-primary-button>
                                                <x-secondary-button type="submit" >
                                                    {{ __('Update Form') }}
                                                </x-secondary-button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener for Add Field button
        document.getElementById('add-field').addEventListener('click', function () {
            var templateField = document.querySelector('.form-group.field-template');
            var newField = templateField.cloneNode(true);
            var index = document.querySelectorAll('.form-group.field').length;
            var inputs = newField.querySelectorAll('input, select');
            inputs.forEach(function(input) {
                var name = input.getAttribute('name');
                input.setAttribute('name', name.replace('[0]', '[' + index + ']'));
                input.value = '';
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                }
                if (input.getAttribute('name').includes('name')) {
                    input.addEventListener('input', function(event) {
                        var inputValue = event.target.value;
                        // Only allow alphanumeric characters and whitespace
                        event.target.value = inputValue.replace(/[^A-Za-z0-9\s]/g, '');
                    });
                } else if (input.classList.contains('option-field')) {
                    // Add input validation for option field
                    input.addEventListener('input', function(event) {
                        var inputValue = event.target.value;
                        // Only allow alphanumeric characters and whitespace
                        event.target.value = inputValue.replace(/[^A-Za-z0-9\s,]/g, '');
                    });
                }
            });
            newField.style.display = 'block';
            newField.querySelector('.remove-field').addEventListener('click', function() {
                newField.remove();
            });
            var optionsContainer = newField.querySelector('.options-container');
            var fieldType = newField.querySelector('.field-type');
            fieldType.addEventListener('change', function() {
                if (fieldType.value === 'select') {
                    optionsContainer.style.display = 'block';
                    optionsContainer.querySelectorAll('input').forEach(function(optionInput) {
                        optionInput.required = true;
                    });
                } else {
                    optionsContainer.style.display = 'none';
                    optionsContainer.querySelectorAll('input').forEach(function(optionInput) {
                        optionInput.required = false;
                    });
                }
            });
            var fieldsContainer = document.getElementById('fields-container');
            fieldsContainer.appendChild(newField);
        });

        // Event listener for Remove Field button
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-field')) {
                event.target.closest('.form-group.field').remove();
            }
        });

        // Event listener for changing field type
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('field-type')) {
                var optionsContainer = event.target.closest('.form-group.field').querySelector('.options-container');
                if (event.target.value === 'select') {
                    optionsContainer.style.display = 'block';
                    optionsContainer.querySelectorAll('input').forEach(function(optionInput) {
                        optionInput.required = true;
                    });
                } else {
                    optionsContainer.style.display = 'none';
                    optionsContainer.querySelectorAll('input').forEach(function(optionInput) {
                        optionInput.required = false;
                    });
                }
            }
        });

        // Add input validation for existing option-field class fields when the document loads
        var optionFields = document.querySelectorAll('.option-field');
        optionFields.forEach(function(optionField) {
            optionField.addEventListener('input', function(event) {
                var inputValue = event.target.value;
                // Only allow alphanumeric characters and whitespace
                event.target.value = inputValue.replace(/[^A-Za-z0-9\s,]/g, '');
            });
        });
    });
</script>




</x-app-layout>
