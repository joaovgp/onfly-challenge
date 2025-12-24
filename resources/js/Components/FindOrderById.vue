<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";

const showModal = ref(false);

const form = useForm({
    id: "",
});

watch(
    () => form.id,
    () => {
        if (form.errors.id) {
            form.clearErrors("id");
        }
    }
);

const submit = () => {
    form.get(route("travel-orders.show", { id: form.id }), {
        onFinish: () => {
            if (!form.hasErrors) {
                showModal.value = false;
                form.reset();
            }
        },
    });
};
</script>

<template>
    <section>
        <PrimaryButton @click="showModal = true">
            Find Travel Order
        </PrimaryButton>

        <Modal :show="showModal" @close="showModal = false">
            <form @submit.prevent="submit" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Find Travel Request by ID
                </h2>

                <div class="mt-6">
                    <InputLabel for="id" value="Travel Order ID" />
                    <TextInput
                        id="id"
                        v-model="form.id"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Ex: 1"
                    />
                    <InputError
                        :message="form.errors.id"
                        class="mt-2"
                    />
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
                        Find Request
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
