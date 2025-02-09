<script setup>
import OrangeButton from '@/Components/OrangeButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingTransfer = ref(false);
const wallet_destination_input = ref(null);
const amount_input = ref(null);

const form = useForm({
    wallet_destination: '',
    amount: '',
});

const confirmTransfer = () => {
    confirmingTransfer.value = true;

    nextTick(() => wallet_destination_input.value.focus());
};

const transfer = () => {
    form.post(route('transfer'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => wallet_destination_input.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingTransfer.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <OrangeButton @click="confirmTransfer">
            <i class="fa-solid fa-money-bill-transfer"></i>
            Transfer
        </OrangeButton>

        <Modal :show="confirmingTransfer" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Transfer Value
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Please enter the wallet code and the amount you wish to transfer.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="wallet_destination"
                        value="Wallet Code"
                        class="sr-only"
                    />

                    <TextInput
                        id="wallet_destination"
                        ref="wallet_destination_input"
                        v-model="form.wallet_destination"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="Wallet Code"
                        required
                    />

                    <InputError :message="form.errors.wallet_destination" class="mt-2" />
                </div>

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

                    <OrangeButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="transfer"
                    >
                        Transfer Value
                    </OrangeButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
