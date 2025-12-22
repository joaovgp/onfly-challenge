<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TravelOrders from "@/Components/TravelOrders.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    orders: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <TravelOrders :orders="orders" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
