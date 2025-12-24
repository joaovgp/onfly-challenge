<script setup>
import TravelOrdersTable from "@/Components/TravelOrdersTable.vue";
import TravelOrdersFilter from "@/Components/TravelOrdersFilter.vue";
import { router } from "@inertiajs/vue3";

defineProps({
    orders: Object,
});

const filter = (filters) => {
    router.get("/dashboard", filters, { preserveState: true });
};

const clearFilters = () => {
    router.get("/dashboard", {}, { preserveState: true });
};
</script>

<template>
    <div class="flex bg-white shadow-sm sm:rounded-lg">
        <TravelOrdersFilter @filter="filter" @clear="clearFilters" />
        <div class="w-3/4">
            <TravelOrdersTable :orders="orders" />
        </div>
    </div>
</template>

