<script setup>
import OrangeButton from '@/Components/OrangeButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <OrangeButton @click="confirmUserDeletion">
            <i class="fa-solid fa-money-bill-transfer"></i>
            Transfer
        </OrangeButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Transfer Value
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Please enter the account number, agency, and the amount you wish to transfer.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="agency"
                        value="Agency"
                        class="sr-only"
                    />

                    <TextInput
                        id="agency"
                        ref="agency_input"
                        v-model="form.agency"
                        type="number"
                        class="mt-1 block w-3/4"
                        placeholder="Agency"
                    />

                    <InputError :message="form.errors.agency" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel
                        for="value"
                        value="Account Number"
                        class="sr-only"
                    />

                    <TextInput
                        id="account_number"
                        ref="account_number_input"
                        v-model="form.account_number"
                        type="number"
                        class="mt-1 block w-3/4"
                        placeholder="Account Number"
                    />

                    <InputError :message="form.errors.account_number" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel
                        for="value"
                        value="Amount"
                        class="sr-only"
                    />

                    <TextInput
                        id="value"
                        ref="value_input"
                        v-model="form.value"
                        type="number"
                        class="mt-1 block w-3/4"
                        placeholder="Amount"
                    />

                    <InputError :message="form.errors.value" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <OrangeButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Transfer Value
                    </OrangeButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
