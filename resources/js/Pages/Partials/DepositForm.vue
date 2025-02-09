<script setup>
import OrangeButton from '@/Components/OrangeButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import GreenButton from '@/Components/GreenButton.vue';

const confirmingDeposit = ref(false);
const amount_input = ref(null);

const form = useForm({
    amount: '',
});

const confirmDeposit = () => {
    confirmingDeposit.value = true;

    nextTick(() => amount_input.value.focus());
};

const deposit = () => {
    form.post(route('deposit.make'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => amount_input.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDeposit.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <GreenButton @click="confirmDeposit">
            <i class="fa-solid fa-landmark"></i>
            Deposit
        </GreenButton>

        <Modal :show="confirmingDeposit" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Deposit Value
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Please enter the amount you wish to deposit.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="amount"
                        value="Amount"
                        class="sr-only"
                    />

                    <TextInput
                        id="amount"
                        ref="amount_input"
                        v-model="form.amount"
                        type="number"
                        class="mt-1 block w-3/4"
                        placeholder="Amount"
                        required
                    />

                    <InputError :message="form.errors.amount" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <GreenButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deposit"
                    >
                        Deposit Value
                    </GreenButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
