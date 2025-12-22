<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";

const showModal = ref(false);

const form = useForm({
    destination: "",
    departure_date: "",
    return_date: "",
});

const submit = () => {
    form.post(route("travel-orders.store"), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <section>
        <PrimaryButton @click="showModal = true">
            Request Travel Order
        </PrimaryButton>

        <Modal :show="showModal" @close="showModal = false">
            <form @submit.prevent="submit" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create Travel Request
                </h2>

                <div class="mt-6">
                    <InputLabel for="destination" value="Destination" />
                    <TextInput
                        id="destination"
                        v-model="form.destination"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Ex: New York, NY"
                    />
                    <InputError
                        :message="form.errors.destination"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <InputLabel
                            for="departure_date"
                            value="Departure Date"
                        />
                        <TextInput
                            id="departure_date"
                            v-model="form.departure_date"
                            type="date"
                            class="mt-1 block w-full"
                        />
                        <InputError
                            :message="form.errors.departure_date"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <InputLabel for="return_date" value="Return Date" />
                        <TextInput
                            id="return_date"
                            v-model="form.return_date"
                            type="date"
                            class="mt-1 block w-full"
                        />
                        <InputError
                            :message="form.errors.return_date"
                            class="mt-2"
                        />
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        @click="showModal = false"
                        class="mr-3 text-gray-600 underline"
                    >
                        Cancel
                    </button>
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Create Request
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
