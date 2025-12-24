<script setup>
import StatusBadge from "@/Components/StatusBadge.vue";
import AdminActions from "@/Components/AdminActions.vue";
import { router, usePage } from "@inertiajs/vue3";

const { user } = usePage().props.auth;

defineProps({
    order: Object,
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
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Requester
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Destination
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Departure Date
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Return Date
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Status
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ order.requester_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ order.destination }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ order.departure_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ order.return_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <StatusBadge :status="order.status" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <AdminActions
                            v-if="user.is_admin"
                            :order="order"
                            @approve="handleApprove"
                            @cancel="handleCancel"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
