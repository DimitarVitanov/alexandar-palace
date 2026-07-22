<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    bookings: Object,
    stats: Object,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const status = ref(props.filters?.status || '');
const courtType = ref(props.filters?.court_type || '');
const date = ref(props.filters?.date || '');

const applyFilters = () => {
    router.get('/admin/tennis-court-bookings', {
        search: search.value || undefined,
        status: status.value || undefined,
        court_type: courtType.value || undefined,
        date: date.value || undefined,
    }, { preserveState: true });
};

const confirmBooking = (id) => {
    if (confirm('Are you sure you want to confirm this booking?')) {
        router.post(`/admin/tennis-court-bookings/${id}/confirm`);
    }
};

const cancelBooking = (id) => {
    if (confirm('Are you sure you want to cancel this booking?')) {
        router.post(`/admin/tennis-court-bookings/${id}/cancel`);
    }
};

const deleteBooking = (id) => {
    if (confirm('Are you sure you want to delete this booking?')) {
        router.delete(`/admin/tennis-court-bookings/${id}`);
    }
};

const getStatusBadge = (status) => {
    const badges = {
        pending: 'bg-warning text-dark',
        confirmed: 'bg-success',
        cancelled: 'bg-danger',
        completed: 'bg-secondary',
    };
    return badges[status] || 'bg-secondary';
};

const getCourtTypeLabel = (type) => {
    const labels = {
        tennis: 'Tennis Court',
        basketball: 'Basketball Court',
        football: 'Football Pitch',
    };
    return labels[type] || type;
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const formatTime = (time) => {
    return time?.substring(0, 5) || '';
};
</script>

<template>
    <AdminLayout title="Tennis Court Bookings">
        <div class="container-fluid py-4">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Bookings</h5>
                            <h2 class="mb-0">{{ stats.total }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <h2 class="mb-0">{{ stats.pending }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Confirmed</h5>
                            <h2 class="mb-0">{{ stats.confirmed }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Upcoming</h5>
                            <h2 class="mb-0">{{ stats.upcoming }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input 
                                type="text" 
                                v-model="search" 
                                class="form-control" 
                                placeholder="Search by name, email..."
                                @keyup.enter="applyFilters"
                            >
                        </div>
                        <div class="col-md-2">
                            <select v-model="status" class="form-select" @change="applyFilters">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select v-model="courtType" class="form-select" @change="applyFilters">
                                <option value="">All Courts</option>
                                <option value="tennis">Tennis</option>
                                <option value="basketball">Basketball</option>
                                <option value="football">Football</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input 
                                type="date" 
                                v-model="date" 
                                class="form-control"
                                @change="applyFilters"
                            >
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary me-2" @click="applyFilters">
                                <i class="bi bi-search"></i> Search
                            </button>
                            <button class="btn btn-outline-secondary" @click="search = ''; status = ''; courtType = ''; date = ''; applyFilters()">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Court Bookings</h5>
                    <a href="/admin/tennis-court-bookings/calendar" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-calendar3"></i> Calendar View
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Court Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Players</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in bookings.data" :key="booking.id">
                                    <td>#{{ booking.id }}</td>
                                    <td>
                                        <strong>{{ booking.name }}</strong><br>
                                        <small class="text-muted">{{ booking.email }}</small>
                                    </td>
                                    <td>{{ getCourtTypeLabel(booking.court_type) }}</td>
                                    <td>{{ formatDate(booking.booking_date) }}</td>
                                    <td>{{ formatTime(booking.start_time) }} - {{ formatTime(booking.end_time) }}</td>
                                    <td>{{ booking.players }}</td>
                                    <td>
                                        <span :class="['badge', getStatusBadge(booking.status)]">
                                            {{ booking.status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a :href="`/admin/tennis-court-bookings/${booking.id}`" class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button 
                                                v-if="booking.status === 'pending'"
                                                class="btn btn-outline-success" 
                                                @click="confirmBooking(booking.id)"
                                                title="Confirm"
                                            >
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button 
                                                v-if="booking.status === 'pending'"
                                                class="btn btn-outline-warning" 
                                                @click="cancelBooking(booking.id)"
                                                title="Cancel"
                                            >
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <button 
                                                class="btn btn-outline-danger" 
                                                @click="deleteBooking(booking.id)"
                                                title="Delete"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="bookings.data.length === 0">
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        No bookings found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div v-if="bookings.last_page > 1" class="card-footer">
                    <nav>
                        <ul class="pagination justify-content-center mb-0">
                            <li v-for="link in bookings.links" :key="link.label" :class="['page-item', { active: link.active, disabled: !link.url }]">
                                <a 
                                    class="page-link" 
                                    :href="link.url"
                                    v-html="link.label"
                                    @click.prevent="link.url && router.get(link.url)"
                                ></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
