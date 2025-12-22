<script setup>
import TravelOrdersTable from "@/Components/TravelOrdersTable.vue";
import CreateOrderModal from "@/Components/CreateOrderModal.vue";

defineProps({
    orders: Object,
});
</script>

<template>
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 flex justify-between items-center border-b">
            <h3 class="text-lg font-medium">My Travel Requests</h3>
            <CreateOrderModal />
        </div>

        <TravelOrdersTable :orders="orders" />
    </div>
</template>
