<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TravelOrders from "@/Components/TravelOrders.vue";
import ViewTravelOrder from "@/Pages/Dashboard/Partials/ViewTravelOrder.vue";
import { Head } from "@inertiajs/vue3";
import DashboardHeader from "@/Components/DashboardHeader.vue";

defineProps({
    orders: Object,
    order: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <DashboardHeader :isDetailedView="!!order" />
                    <ViewTravelOrder v-if="order" :order="order" />
                    <TravelOrders v-else :orders="orders" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
