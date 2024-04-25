<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-200 text-green-800 border border-green-600 rounded-md px-4 py-3 mb-3">
                {{ session('success') }}
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
                                        Form Name
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
                                    <td class="px-4 py-2 border border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase">
                                        <a href="{{ route('forms.edit', $form) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Edit</a>
                                        <a href="{{ route('forms.submissions.list', $form) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">View Submissions</a>
                                         <a href="#" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Delete</a>

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
        </div>
    </div>
</x-app-layout>
