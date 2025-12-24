<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import StatusBadge from "@/Components/StatusBadge.vue";
import AdminActions from "@/Components/AdminActions.vue";

const { user } = usePage().props.auth;

defineProps({
    orders: Object,
});

const handleApprove = (order) => {
    router.post(
        route("travel-orders.approve", { order: order.id }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};

const handleCancel = (order) => {
    router.post(
        route("travel-orders.cancel", { order: order.id }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
</script>

<template>
    <div class="p-6">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Requester</th>
                    <th class="px-6 py-3">Destination</th>
                    <th class="px-6 py-3">Departure Date</th>
                    <th class="px-6 py-3">Return Date</th>
                    <th class="px-6 py-3">Status</th>
                    <th v-if="user.is_admin" class="px-1 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="order in orders.data"
                    :key="order.id"
                    class="bg-white border-b"
                >
                    <td class="px-6 py-4">{{ order.requester_name }}</td>
                    <td class="px-6 py-4">{{ order.destination }}</td>
                    <td class="px-6 py-4">
                        {{ order.departure_date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ order.return_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <StatusBadge :status="order.status" />
                    </td>
                    <td v-if="user.is_admin" class="px-1 py-4" title="View order">
                        <div class="flex items-center gap-8">
                            <AdminActions
                                :order="order"
                                @approve="handleApprove"
                                @cancel="handleCancel"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex items-center justify-center space-x-1">
            <template v-for="(link, k) in orders.links" :key="k">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    v-html="link.label"
                    class="px-4 py-2 border rounded-md text-sm"
                    :class="{
                        'bg-blue-600 text-white': link.active,
                        'bg-white': !link.active,
                    }"
                    preserve-scroll
                    preserve-state
                />
                <span
                    v-else
                    v-html="link.label"
                    class="px-4 py-2 border rounded-md text-sm text-gray-400"
                />
            </template>
        </div>
    </div>
</template>
