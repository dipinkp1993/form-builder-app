<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$form->name }} Submissions<br><small><i>{{$form->description }}</i></small>
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
                                    @foreach ($form->fields as $field)                         
                                    <td class="px-4 py-2 border border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
                                        {{$field->label}}
                                    </td>
                                    @endforeach
                                    
                                </tr>
                            </thead> 
                            <tbody class="divide-y divide-gray-200">
                           @foreach($submissions as $submission) 
                            <tr>
                            <td class="px-4 py-2 border border-gray-200 text-left text-xs font-semibold text-gray-600">{{$loop->index+1}}</td>
                            @foreach ($form->fields as $field)  
                            <td class="px-4 py-2 border border-gray-200 text-left text-xs font-semibold text-gray-600">{{$submission->{$field->name} }}</td>
                            @endforeach
                
                
                            </tr>
                           @endforeach
                              
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination links -->
                    <div class="p-6">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
