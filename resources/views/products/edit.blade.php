<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div class="min-w-full align-middle">
                        <form action="{{ route('products.update', $product) }}" method="POST">
                            @csrf
                            @method('PUT')


                            <table class="min-w-full divide-y divide-gray-200 border mt-6 mb-6 ">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left">
                                            <span
                                                class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left">
                                            <span
                                                class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price
                                                (USD)</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input class="border-0 border-b-2 border-gray-200" type="text"
                                                id="name" name="name" value="{{ $product->name }}" required />
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <input class="border-0 border-b-2 border-gray-200" type="text"
                                                id="price" name="price" value="{{ $product->price }}" required />

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @if (auth()->user()->is_admin)
                                <div class="mb-6 flex justify-between">

                                    <div>
                                        <a href="{{ route('products.index') }}">
                                            <x-secondary-button>Cancel</x-secondary-button>
                                        </a>
                                        <a href="">
                                            <x-primary-button>Update Product</x-primary-button>
                                        </a>
                                    </div>
                                    <div>
                                        <a onclick="return confirm('Are you sure?')">
                                            <x-danger-button form="delete-form">Delete</x-danger-button>
                                        </a>
                                    </div>
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

                        </form>
                        <form action="/products/{{ $product->id }}" method="POST" id="delete-form">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
