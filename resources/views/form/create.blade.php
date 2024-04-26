<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                                        Create Form
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

                                        <form method="POST" action="{{ route('forms.store') }}">
                                            @csrf

                                            <div class="mb-4">
                                                <label for="name" class="block text-gray-700 font-bold mb-2">Form Name</label>
                                                <input type="text" name="name" id="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                                                <textarea name="description" id="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                            </div>

                                            <div id="fields-container">
                                                <label class="block text-gray-700 font-bold mb-2">Form Fields</label>
                                                <!-- Template field for cloning -->
                                                <div class="form-group field field-template mb-4">
                                                    <input type="text" name="fields[0][label]" placeholder="Label" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                    <input type="text" name="fields[0][name]" placeholder="Name Attribute" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                    <select name="fields[0][type]" class="form-select field-type" required>
                                                        <option value="text">Text</option>
                                                        <option value="email">Email</option>
                                                        <option value="number">Number</option>
                                                        <option value="select">Select</option>
                                                        <!-- Add other field types as needed -->
                                                    </select>
                                                    <div class="options-container" style="display: none;">
                                                        <input type="text" name="fields[0][options][]" placeholder="Option" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm option-field">
                                                        <br>(<small>*Note:Add comma seperated options</small>)
                                                    </div>
                                                    <a type="button" class="remove-field ml-2 px-2 py-1 bg-red-500 text-red rounded">Remove</a>
                                                </div>
                                            </div>

                                            <div class="flex justify-between mt-4">
                                                <x-primary-button id="add-field">{{ __('Add Field') }}</x-primary-button>
                                                <x-secondary-button type="submit" >
                                                    {{ __('Save Form') }}
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
        document.getElementById('add-field').addEventListener('click', function () {
            // Find the template field
            var templateField = document.querySelector('.form-group.field-template');
            
            // Clone the template field
            var newField = templateField.cloneNode(true);
            
            // Increment index in field names
            var index = document.querySelectorAll('.form-group.field').length;
            var inputs = newField.querySelectorAll('input, select');
            inputs.forEach(function(input) {
                var name = input.getAttribute('name');
                input.setAttribute('name', name.replace('[0]', '[' + index + ']'));
                // Clear value for new field
                input.value = '';
                if (input.getAttribute('name').includes('name')) {
                    input.addEventListener('input', function(event) {
                        var inputValue = event.target.value;
                       if (!/^[A-Za-z_\s]+$/.test(inputValue)) {
                            event.target.value = inputValue.slice(0, -1);
                        }
                    });
                
                } else if (input.classList.contains('option-field')) {
                        // Add input validation for option field
                        input.addEventListener('input', function(event) {
                            var inputValue = event.target.value;
                            event.target.value = inputValue.replace(/[^a-zA-Z0-9\s,]/g, '');
                        });
                    }
            
            });
            
            // Show the new field
            newField.style.display = 'block';
            
            // Add event listener to remove button
            var removeButton = newField.querySelector('.remove-field');
            removeButton.addEventListener('click', function() {
                newField.remove();
            });
            
            // Append the new field to the container
            var fieldsContainer = document.getElementById('fields-container');
            fieldsContainer.appendChild(newField);
        });

        // Event listener for changing field type
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('field-type')) {
                var optionsContainer = event.target.closest('.form-group.field').querySelector('.options-container');
                if (event.target.value === 'select') {
                    optionsContainer.style.display = 'block';
                    optionsContainer.querySelector('input').required = true;
                } else {
                    optionsContainer.style.display = 'none';
                    optionsContainer.querySelector('input').required = false;
                }
            }
        });
    </script>
</x-app-layout>
