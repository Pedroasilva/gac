<script>
import Receipt from '@/Pages/Partials/Receipt.vue';

export default {
    name: 'Transaction',
    components: {
        Receipt
    },
    props: {
        date: {
            type: String,
            required: true
        },
        group: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: true
        },
        amount: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        }
    },
    methods: {
        handleReceipt(group) {

            console.log('Receipt for group:', group);
        },
        handleReverse(group) {
            console.log('Reverse for group:', group);
        }
    }
}
</script>

<template>
    <div
        class="bg-gray-200 p-2 mb-2 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center hover:bg-gray-300">
        <div class="mb-2 md:mb-0">
            <p class="text-xs text-gray-600">{{ date }}</p>
            <p :class="{ 'text-red-600': type === 'out', 'text-green-600': type === 'in' }" class="text-xl">
                {{ amount }} -
                {{ description }}
            </p>
        </div>
        <div class="flex space-x-2">
            <Receipt :group="group" />
            <!-- <button class="bg-blue-600 text-white text-sm px-2 py-1 rounded-lg hover:bg-blue-800 transition duration-300"
                @click="handleReceipt(group)">
                <i class="fa-solid fa-receipt"></i>
                Receipt
            </button> -->
            <button class="bg-red-600 text-white text-sm px-2 py-1 rounded-lg hover:bg-red-800 transition duration-300"
                @click="handleReverse(group)">
                <i class="fa-solid fa-rotate-left"></i>
                Reverse
            </button>
        </div>
    </div>
</template>
