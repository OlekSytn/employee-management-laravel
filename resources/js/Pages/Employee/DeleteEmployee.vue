<script setup>
    import { reactive, ref, toRefs, watch, unref, toRaw } from 'vue'

    const props = defineProps({
        dialogVisible: Boolean,
        employee: Object
    });

    const emit = defineEmits(['getEmployees', 'closeDialog'])
    const { dialogVisible, employee } = toRefs(props)

    async function deleteEmployee() {
        const result = 
            await fetch(`/api/employees/${employee.value.id}`, {
                method: 'DELETE', // *GET, POST, PUT, DELETE, etc.
            }).then(response => response.json())

        emit('getEmployees')
        emit('closeDialog', `Employee ${employee.value.last_name}, ${employee.value.first_name} has been deleted`)
        console.log('res ', result);
    }
</script>

<template>
    <!-- Main modal -->
    <div v-if="dialogVisible" tabindex="-1" aria-hidden="true" class="bg-black opacity-75 grid h-screen place-items-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center"></div>
    <div v-if="dialogVisible" id="deleteUserModal" tabindex="-1" aria-hidden="true" class="grid h-screen place-items-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button @click="$emit('closeDialog')" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Delete employee</h3>
                    <div class="space-y-6">
                        <div>
                            <span>Do you want to delete {{ employee.last_name }}, {{ employee.first_name }}?</span>
                        </div>
                        <button @click="deleteEmployee" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div> 

</template>