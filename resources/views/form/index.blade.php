<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forms') }}
        </h2>
        
    </x-slot>

    <div class="py-12">
   
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('forms.create') }}" class="inline-flex justify-right items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Create Form</a>
            </div>
            @if ($forms->isEmpty())
               <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <img src="{{asset('images/no_forms.webp')}}" style="max-width: 50%; display: block; margin: 0 auto;" alt="Description of the image">
                        <p>No forms added yet.</p>
                    </div>
                </div>


            @else
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 bg-green text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-200 text-red-800 rounded-lg p-3 mb-3">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse">
                                <thead>
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Sl No
                                        </td>
                                        <td class="px-4 py-2 border border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Name
                                        </td>
                                        <td class="px-4 py-2 border border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                            Description
                                        </td>
                                        <td class="px-4 py-2 border border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase">
                                            Actions
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($forms as $form)
                                        <tr>
                                            <td class="px-4 py-2 border border-gray-200 text-left text-xs font-semibold text-gray-600">
                                                {{ ($forms->currentPage()-1) * $forms->perPage() + $loop->index + 1 }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-200  text-left text-xs font-semibold text-gray-600">
                                                {{ $form->name }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-200  text-left text-xs font-semibold text-gray-600">
                                                {{ $form->description }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase">
                                                <div class="flex items-center space-x-4 ">
                                                    <a href="{{ route('forms.edit', $form) }}" class="inline-flex items-center px-4 py-2  bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Edit</a>
                                                    <a href="{{ route('forms.submissions.list', $form) }}" class="inline-flex items-center px-4 py-2 ml-4 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">View Submissions</a>
                                                    <form action="{{ route('forms.destroy', $form) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-4 py-2 ml-4 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this form?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination links -->
                        <div class="p-6">
                            {{ $forms->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
