<x-app-layout>
    <form
        x-on:submit.prevent="submit"
        x-data="{
            error: null,

            form: {
                employee_id: {{ $employee->id }},
                service_id: {{ $service->id }},
                date: null,
                time: null,
                name: null,
                email: null
            },

            submit () {
                axios.post('{{ route('appointments') }}', this.form).then((response) => {
                    window.location = response.data.redirect
                }).catch((error) => {
                    this.error = error.response.data.error
                })
            }
        }"
        class="space-y-12"
    >
        <div>
            <h2 class="text-xl font-medium mt-3">Here's what you're booking</h2>
            <div class="flex mt-6 space-x-3 bg-slate-100 rounded-lg p-4">
                <img src="{{ $employee->profile_photo_url }}" class="rounded-lg size-14 bg-slate-100">
                <div class="w-full">
                    <div class="flex justify-between">
                        <div class="font-semibold">
                            {{ $service->title }} ({{ $service->duration }} minutes)
                        </div>
                        <div class="text-sm">
                            {{ $service->price }}
                        </div>
                    </div>
                    <div class="text-sm">
                        {{ $employee->name }}
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-lg font-medium mt-3">1. When for?</h2>
            <div
                x-data="{
                    picker: null,
                    availableDates: {{ json_encode($availableDates) }}
                }"
                x-init="
                    this.picker = new easepick.create({
                        element: $refs.date,
                        readonly: true,
                        zIndex: 50,
                        date: '{{ $firstAvailableDate }}',
                        css: [
                            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
                            '/vendor/easepick/easepick.css'
                        ],
                        plugins: [
                            'LockPlugin'
                        ],
                        LockPlugin: {
                            minDate: new Date(),
                            filter (date, picked) {
                                return !Object.keys(availableDates).includes(date.format('YYYY-MM-DD'))
                            }
                        },
                        setup (picker) {
                            picker.on('view', (e) => {
                                const { view, date, target } = e.detail
                                const dateString = date ? date.format('YYYY-MM-DD') : null

                                if (view === 'CalendarDay' && availableDates[dateString]) {
                                    const span = target.querySelector('.day-slots') || document.createElement('span')

                                    span.className = 'day-slots'
                                    span.innerHTML = pluralize('slot', availableDates[dateString], true)

                                    target.append(span)
                                }
                            })
                        }
                    })

                    this.picker.on('select', (e) => {
                        form.date = new easepick.DateTime(e.detail.date).format('YYYY-MM-DD')
                        $dispatch('slots-requested')
                    })

                    $nextTick(() => {
                        this.picker.trigger('select', { date: '{{ $firstAvailableDate }}' })
                    })
                "
            >
                <input x-ref="date" class="mt-6 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full" placeholder="Choose a date">
            </div>
        </div>

        <div
            x-data="{
                slots: [],
                fetchSlots (event) {
                    axios.get(`{{ route('slots', [$employee, $service]) }}?date=${form.date}`).then((response) => {
                        this.slots = response.data.times
                    })
                }
            }"
            x-on:slots-requested.window="fetchSlots(event)"
        >
            <h2 class="text-lg font-medium mt-3">2. Choose a time slot</h2>
            <div class="mt-6" x-show="slots.length">
                <div class="grid grid-cols-3 md:grid-cols-5 gap-8 mt-6">
                    <template x-for="slot in slots">
                        <div x-text="slot" class="py-3 px-4 text-sm border border-slate-200 rounded-lg text-center hover:bg-gray-50/75 cursor-pointer" x-on:click="form.time = slot" x-bind:class="{ 'bg-slate-100 hover:bg-slate-100': form.time === slot }"></div>
                    </template>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-medium mt-3">3. Your details and book</h2>

            <div x-show="error" x-text="error" x-cloak class="bg-slate-900 text-white py-4 px-6 rounded-lg mt-3"></div>

            <div class="mt-6" x-show="form.time" x-cloak>
                <div>
                    <label for="name" class="sr-only">Your name</label>
                    <input type="text" name="name" id="name" placeholder="Your name" class="mt-1 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full" required x-model="form.name">
                </div>

                <div class="mt-3">
                    <label for="email" class="sr-only">Your email address</label>
                    <input type="email" name="email" id="email" placeholder="Your email address" class="mt-1 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full" required x-model="form.email">
                </div>

                <button type="submit" class="mt-6 py-3 px-6 text-sm border border-slate-200 rounded-lg flex flex-col items-center justify-center text-center hover:bg-slate-900 cursor-pointer bg-slate-800 text-white font-medium">Make booking</button>
            </div>
        </div>
    </form>
</x-app-layout>
