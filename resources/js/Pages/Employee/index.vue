<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import UpdateEmployee from './UpdateEmployee.vue';
    import DeleteEmployee from './DeleteEmployee.vue';
    import CreateEmployee from './CreateEmployee.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, onMounted } from 'vue'

    const openCreateDialog = ref(false)
    const openUpdateDialog = ref(false)
    const openDeleteDialog = ref(false)
    const employees = ref([])
    const employee = ref({})
    const childMsg = ref('')
    const keyword = ref('')
    const isLoading = ref(true)

    function showUpdateDialog(u) {
        openUpdateDialog.value = true
        employee.value = u
        console.log(employee)
    }

    function showDeleteDialog(u) {
        openDeleteDialog.value = true
        employee.value = u
        console.log(employee)
    }

    function closeDialog(msg) {
        openCreateDialog.value = false
        openUpdateDialog.value = false
        openDeleteDialog.value = false

        if (msg) {
            childMsg.value = msg
        }
    }

    async function getEmployees() {
        const result = await fetch(`/api/employees?search=${keyword.value}`).then(response => response.json())
        employees.value = result
        isLoading.value = false
        console.log('res ', employees.value)
    }

    onMounted(function() {
        getEmployees()
    })
</script>
<template>
    <Head title="User Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div v-if="childMsg" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                            {{ childMsg }}
                        </div>

                        <div class="flex justify-between relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input @keyup.enter="getEmployees" v-model="keyword" type="text" id="email-address-icon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">

                            <button 
                                @click="openCreateDialog = true"
                                type="button" class="order-last text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                data-modal-toggle="createUserModal">
                                Create Employee
                            </button>
                        </div>

                        <div v-if="!isLoading" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-4">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Employee Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Address
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Department
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Country
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            State
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            City
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(employee, index) in employees" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ employee.last_name }}, {{ employee.first_name }} {{ employee.middle_name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ employee.address }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ employee.department_id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ employee.country_id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ employee.state_id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ employee.city_id }}
                                        </td>
                                        <td class="flex px-6 py-4 text-right">
                                            <a @click="showUpdateDialog(employee)" class="cursor-pointer">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <a class="ml-4 cursor-pointer"  @click="showDeleteDialog(employee)">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <CreateEmployee :dialogVisible="openCreateDialog" @closeDialog="closeDialog" @getEmployees="getEmployees" />
        <UpdateEmployee :dialogVisible="openUpdateDialog" :employee="employee" @closeDialog="closeDialog" @getEmployees="getEmployees" />
        <DeleteEmployee :dialogVisible="openDeleteDialog" :employee="employee" @closeDialog="closeDialog" @getEmployees="getEmployees" />
    </BreezeAuthenticatedLayout>
</template>
