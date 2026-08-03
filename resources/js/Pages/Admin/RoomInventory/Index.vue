<script setup>
import { computed, ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import AvailabilityCalendars from '@/Components/AvailabilityCalendars.vue';

const props = defineProps({
    rooms: Array,
    selectedRoomId: Number,
    calendar: Array,
    range: Object,
});

const roomName = (room) => (typeof room?.name === 'object' ? (room.name.en || Object.values(room.name)[0]) : room?.name);

const selectedRoom = computed(() => props.rooms.find((room) => room.id === props.selectedRoomId));

const selectedRoomName = computed(() => roomName(selectedRoom.value));

const reload = (params) => {
    router.get('/admin/room-availability', {
        room_id: props.selectedRoomId,
        start: props.range.start,
        months: props.range.months,
        ...params,
    }, { preserveScroll: true, preserveState: true });
};

const selectRoom = (event) => reload({ room_id: Number(event.target.value), start: props.range.start });

const shiftMonths = (direction) => {
    const [year, month] = props.range.start.split('-').map(Number);
    const next = new Date(year, month - 1 + direction, 1);
    const start = `${next.getFullYear()}-${String(next.getMonth() + 1).padStart(2, '0')}-01`;
    reload({ start });
};

const setMonths = (event) => reload({ months: Number(event.target.value) });

// --- period form (bulk: "30 single rooms available from X to Y") ---
const periodForm = useForm({
    id: null,
    date_from: '',
    date_to: '',
    quantity: 1,
    notes: '',
});

const editPeriod = (period) => {
    periodForm.id = period.id;
    periodForm.date_from = period.date_from;
    periodForm.date_to = period.date_to;
    periodForm.quantity = period.quantity;
    periodForm.notes = period.notes || '';
};

const resetPeriod = () => {
    periodForm.reset();
    periodForm.id = null;
};

const savePeriod = () => {
    if (periodForm.id) {
        periodForm.put(`/admin/room-availability/${periodForm.id}`, {
            preserveScroll: true,
            onSuccess: resetPeriod,
        });
        return;
    }

    periodForm.post(`/admin/rooms/${props.selectedRoomId}/availability`, {
        preserveScroll: true,
        onSuccess: resetPeriod,
    });
};

const deletePeriod = (period) => {
    if (!confirm('Remove this availability period?')) return;
    router.delete(`/admin/room-availability/${period.id}`, { preserveScroll: true });
};

// --- boost modal (click a date on the calendar) ---
const boostForm = useForm({
    date_from: '',
    date_to: '',
    quantity: 1,
    notes: '',
});

const modalOpen = ref(false);
const modalInfo = ref(null);

const openBoost = (cell) => {
    modalInfo.value = cell.info;
    boostForm.date_from = cell.key;
    boostForm.date_to = cell.key;
    boostForm.quantity = cell.info?.capacity || selectedRoom.value?.total_units || 1;
    boostForm.notes = '';
    modalOpen.value = true;
};

const submitBoost = () => {
    boostForm.post(`/admin/rooms/${props.selectedRoomId}/availability`, {
        preserveScroll: true,
        onSuccess: () => {
            modalOpen.value = false;
            boostForm.reset();
        },
    });
};
</script>

<template>
    <Layout title="Room Availability">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Room Availability</h1>
                <p class="text-slate-600 mt-1">Set how many rooms of each type are bookable per date range — no individual room numbers needed.</p>
            </div>
            <div class="flex items-end gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Room type</label>
                    <select :value="selectedRoomId" class="border border-slate-300 rounded-lg px-3 py-2" @change="selectRoom">
                        <option v-for="room in rooms" :key="room.id" :value="room.id">{{ roomName(room) }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Months</label>
                    <select :value="range.months" class="border border-slate-300 rounded-lg px-3 py-2" @change="setMonths">
                        <option :value="3">3</option>
                        <option :value="6">6</option>
                        <option :value="12">12</option>
                    </select>
                </div>
            </div>
        </div>

        <div v-if="$page.props.flash?.success" class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800">
            {{ $page.props.flash.success }}
        </div>

        <div v-if="rooms.length" class="mb-6 flex flex-wrap gap-2">
            <button
                v-for="room in rooms"
                :key="room.id"
                type="button"
                class="rounded-full border px-4 py-2 text-sm"
                :class="room.id === selectedRoomId
                    ? 'border-amber-600 bg-amber-600 text-white'
                    : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-50'"
                @click="reload({ room_id: room.id })"
            >
                {{ roomName(room) }}
                <span class="ml-1 opacity-70">({{ room.inventories.length ? room.inventories.length + ' periods' : room.total_units + ' default' }})</span>
            </button>
        </div>

        <div v-if="!selectedRoom" class="rounded-lg bg-white border border-slate-200 p-6 text-slate-600">
            No rooms found. Create a room first.
        </div>

        <template v-else>
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-lg bg-white border border-slate-200 p-5">
                    <h2 class="font-semibold text-slate-800 mb-1">
                        Availability calendar — <span class="text-amber-700">{{ selectedRoomName }}</span>
                    </h2>
                    <p class="text-sm text-slate-500 mb-4">
                        Click any date to boost or reduce the room quantity. Green = free, yellow = half of the capacity taken, red = fully booked, grey = no rooms released.
                    </p>
                    <AvailabilityCalendars
                        :days="calendar"
                        :start-month="range.start"
                        :months="range.months"
                        @select-date="openBoost"
                        @shift-months="shiftMonths"
                    />
                </div>

                <div class="rounded-lg bg-white border border-slate-200 p-5">
                    <h2 class="font-semibold text-slate-800 mb-1">
                        {{ periodForm.id ? 'Edit availability period' : 'Release rooms for a period' }}
                    </h2>
                    <p class="text-sm text-slate-500 mb-4">Room type: <strong>{{ selectedRoomName }}</strong></p>
                    <form class="space-y-3" @submit.prevent="savePeriod">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">From</label>
                            <input v-model="periodForm.date_from" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                            <p v-if="periodForm.errors.date_from" class="text-sm text-red-600 mt-1">{{ periodForm.errors.date_from }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">To</label>
                            <input v-model="periodForm.date_to" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                            <p v-if="periodForm.errors.date_to" class="text-sm text-red-600 mt-1">{{ periodForm.errors.date_to }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Rooms available (quantity)</label>
                            <input v-model.number="periodForm.quantity" type="number" min="0" max="1000" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                            <p v-if="periodForm.errors.quantity" class="text-sm text-red-600 mt-1">{{ periodForm.errors.quantity }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Notes</label>
                            <input v-model="periodForm.notes" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. summer season">
                        </div>
                        <div class="flex gap-2 pt-1">
                            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700" :disabled="periodForm.processing">
                                {{ periodForm.processing ? 'Saving...' : (periodForm.id ? 'Update' : 'Save') }}
                            </button>
                            <button v-if="periodForm.id" type="button" class="px-4 py-2 border border-slate-300 rounded-lg" @click="resetPeriod">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 rounded-lg bg-white border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <h2 class="font-semibold text-slate-800">Availability periods — {{ selectedRoomName }}</h2>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="text-left px-5 py-2">From</th>
                            <th class="text-left px-5 py-2">To</th>
                            <th class="text-left px-5 py-2">Rooms</th>
                            <th class="text-left px-5 py-2">Notes</th>
                            <th class="px-5 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="period in selectedRoom.inventories" :key="period.id" class="border-t border-slate-100">
                            <td class="px-5 py-2">{{ period.date_from }}</td>
                            <td class="px-5 py-2">{{ period.date_to }}</td>
                            <td class="px-5 py-2 font-semibold">{{ period.quantity }}</td>
                            <td class="px-5 py-2 text-slate-500">{{ period.notes }}</td>
                            <td class="px-5 py-2 text-right whitespace-nowrap">
                                <button type="button" class="text-amber-600 hover:text-amber-800 mr-3" @click="editPeriod(period)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800" @click="deletePeriod(period)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!selectedRoom.inventories.length">
                            <td colspan="5" class="px-5 py-4 text-slate-500">
                                No periods yet — the room falls back to its default capacity of {{ selectedRoom.total_units }} rooms.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>

        <div v-if="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="modalOpen = false">
            <div class="w-full max-w-md rounded-lg bg-white p-6">
                <h3 class="text-lg font-semibold text-slate-800">Boost room quantity</h3>
                <p class="text-sm text-slate-500 mb-4">
                    <span class="font-medium text-slate-700">{{ selectedRoomName }}</span> — {{ boostForm.date_from }}
                </p>

                <div v-if="modalInfo" class="mb-4 grid grid-cols-3 gap-2 text-center">
                    <div class="rounded bg-slate-50 py-2">
                        <div class="text-xs text-slate-500">Capacity</div>
                        <div class="font-semibold">{{ modalInfo.capacity }}</div>
                    </div>
                    <div class="rounded bg-slate-50 py-2">
                        <div class="text-xs text-slate-500">Booked</div>
                        <div class="font-semibold">{{ modalInfo.booked }}</div>
                    </div>
                    <div class="rounded bg-slate-50 py-2">
                        <div class="text-xs text-slate-500">Free</div>
                        <div class="font-semibold">{{ modalInfo.available }}</div>
                    </div>
                </div>

                <form class="space-y-3" @submit.prevent="submitBoost">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">From</label>
                            <input v-model="boostForm.date_from" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">To</label>
                            <input v-model="boostForm.date_to" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Rooms available</label>
                        <input v-model.number="boostForm.quantity" type="number" min="0" max="1000" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <p class="text-xs text-slate-500 mt-1">The highest quantity covering a date wins, so this immediately boosts availability.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Notes</label>
                        <input v-model="boostForm.notes" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="e.g. tennis team block">
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700" :disabled="boostForm.processing">
                            {{ boostForm.processing ? 'Saving...' : 'Apply' }}
                        </button>
                        <button type="button" class="px-4 py-2 border border-slate-300 rounded-lg" @click="modalOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>
