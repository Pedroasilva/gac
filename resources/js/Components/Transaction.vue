<script>
export default {
    name: 'Transaction',
    props: {
        date: {
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
        handleReceipt() {
            // Handle receipt action
        },
        handleReverse() {
            // Handle reverse action
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
            <button class="bg-blue-600 text-white text-sm px-2 py-1 rounded-lg hover:bg-blue-800 transition duration-300"
                @click="handleReceipt">
                <i class="fa-solid fa-receipt"></i>
                Receipt
            </button>
            <button class="bg-red-600 text-white text-sm px-2 py-1 rounded-lg hover:bg-red-800 transition duration-300"
                @click="handleReverse">
                <i class="fa-solid fa-rotate-left"></i>
                Reverse
            </button>
        </div>
    </div>
</template>

<style scoped>
/* Add any component-specific styles here */
</style>
