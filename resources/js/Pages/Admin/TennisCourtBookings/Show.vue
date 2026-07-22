<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layout.vue';

const props = defineProps({
    booking: Object,
});

const form = useForm({
    status: props.booking.status,
    admin_notes: props.booking.admin_notes || '',
});

const updateBooking = () => {
    form.put(`/admin/tennis-court-bookings/${props.booking.id}`, {
        preserveScroll: true,
    });
};

const confirmBooking = () => {
    if (confirm('Are you sure you want to confirm this booking? An email will be sent to the customer.')) {
        router.post(`/admin/tennis-court-bookings/${props.booking.id}/confirm`);
    }
};

const cancelBooking = () => {
    if (confirm('Are you sure you want to cancel this booking?')) {
        router.post(`/admin/tennis-court-bookings/${props.booking.id}/cancel`);
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
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    });
};

const formatTime = (time) => {
    return time?.substring(0, 5) || '';
};

const formatDateTime = (datetime) => {
    if (!datetime) return '-';
    return new Date(datetime).toLocaleString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <AdminLayout title="Booking Details">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Booking Details Card -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Booking #{{ booking.id }}</h5>
                            <span :class="['badge', getStatusBadge(booking.status)]">
                                {{ booking.status }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Customer Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="120">Name:</th>
                                            <td>{{ booking.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                <a :href="`mailto:${booking.email}`">{{ booking.email }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>
                                                <a v-if="booking.phone" :href="`tel:${booking.phone}`">{{ booking.phone }}</a>
                                                <span v-else class="text-muted">-</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Language:</th>
                                            <td>{{ booking.locale === 'mk' ? 'Macedonian' : 'English' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Booking Details</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="120">Court Type:</th>
                                            <td>
                                                <strong>{{ getCourtTypeLabel(booking.court_type) }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date:</th>
                                            <td>{{ formatDate(booking.booking_date) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Time:</th>
                                            <td>{{ formatTime(booking.start_time) }} - {{ formatTime(booking.end_time) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Players:</th>
                                            <td>{{ booking.players }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div v-if="booking.message" class="mt-4">
                                <h6 class="text-muted mb-2">Customer Message</h6>
                                <div class="bg-light p-3 rounded">
                                    {{ booking.message }}
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Created:</strong> {{ formatDateTime(booking.created_at) }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Confirmed:</strong> {{ formatDateTime(booking.confirmed_at) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Notes Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Admin Notes</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateBooking">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select v-model="form.status" class="form-select">
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Internal Notes</label>
                                    <textarea 
                                        v-model="form.admin_notes" 
                                        class="form-control" 
                                        rows="4"
                                        placeholder="Add internal notes about this booking..."
                                    ></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                                    <i class="bi bi-save me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Actions Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button 
                                    v-if="booking.status === 'pending'"
                                    class="btn btn-success" 
                                    @click="confirmBooking"
                                >
                                    <i class="bi bi-check-circle me-1"></i> Confirm Booking
                                </button>
                                <button 
                                    v-if="booking.status === 'pending'"
                                    class="btn btn-warning" 
                                    @click="cancelBooking"
                                >
                                    <i class="bi bi-x-circle me-1"></i> Cancel Booking
                                </button>
                                <a :href="`mailto:${booking.email}`" class="btn btn-outline-primary">
                                    <i class="bi bi-envelope me-1"></i> Email Customer
                                </a>
                                <a v-if="booking.phone" :href="`tel:${booking.phone}`" class="btn btn-outline-secondary">
                                    <i class="bi bi-telephone me-1"></i> Call Customer
                                </a>
                                <a href="/admin/tennis-court-bookings" class="btn btn-outline-dark">
                                    <i class="bi bi-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Quick Info</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Booking ID</span>
                                <strong>#{{ booking.id }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Court</span>
                                <strong>{{ getCourtTypeLabel(booking.court_type) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Duration</span>
                                <strong>{{ formatTime(booking.start_time) }} - {{ formatTime(booking.end_time) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Players</span>
                                <strong>{{ booking.players }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
