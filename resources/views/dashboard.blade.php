<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <!-- ปรับปรุงลิงก์ -->
                    <div class="mt-6">
                        <a href="{{ url('/technician-repairs') }}" class="inline-block px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:bg-blue-700 hover:scale-105">
                            ดูรายการแจ้งซ่อมที่ช่างรับผิดชอบ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
