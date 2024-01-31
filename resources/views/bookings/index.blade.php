<x-app-layout>
    <div>
        <h2 class="text-xl font-medium">Choose a professional</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mt-6">
            @foreach ($employees as $employee)
                <a href="{{ route('bookings.employee', $employee) }}" class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray-50/75">
                    <img src="{{ $employee->profile_photo_url }}" class="rounded-full size-14 bg-slate-100">
                    <div class="text-sm font-medium mt-3 text-slate-600">
                        {{ $employee->name }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
