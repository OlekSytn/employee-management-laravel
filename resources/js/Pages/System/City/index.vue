<script setup>
    import SystemAuthenticatedLayout from '@/Pages/System/index.vue';
    import CreateCity from '@/Pages/System/City/CreateCity.vue'
    import UpdateCity from '@/Pages/System/City/UpdateCity.vue'
    import DeleteCity from '@/Pages/System/City/DeleteCity.vue'
    
    import { ref, onMounted } from 'vue'

    const openCreateDialog = ref(false)
    const openUpdateDialog = ref(false)
    const openDeleteDialog = ref(false)
    const cities = ref([])
    const city = ref({})
    const childMsg = ref('')
    const keyword = ref('')
    const isLoading = ref(true)

    function showUpdateDialog(u) {
        openUpdateDialog.value = true
        city.value = u
        console.log(city)
    }

    function showDeleteDialog(u) {
        openDeleteDialog.value = true
        city.value = u
        console.log(city, u)
    }

    function closeDialog(msg) {
        openCreateDialog.value = false
        openUpdateDialog.value = false
        openDeleteDialog.value = false

        if (msg) {
            childMsg.value = msg
        }
    }

    async function getCities() {
        const result = await fetch(`/api/cities`).then(response => response.json())
        cities.value = result
        isLoading.value = false
        console.log('res ', cities.value)
    }

    onMounted(function() {
        getCities()
    })
</script>

<template>
    <!-- Table -->
    <SystemAuthenticatedLayout>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                        
                <div v-if="childMsg" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    {{ childMsg }}
                </div>

                <div class="flex justify-between relative">
                    <button 
                        @click="openCreateDialog = true"
                        type="button" class="order-last text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        data-modal-toggle="createCountryModal">
                        Create City
                    </button>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Country Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    State Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    City Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(city, index) in cities" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ city.c_name }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ city.s_name }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ city.name }}
                                </th>
                                <td class="flex px-6 py-4 text-right">
                                    <a @click="showUpdateDialog(city)" class="cursor-pointer">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <a class="ml-4 cursor-pointer"  @click="showDeleteDialog(city)">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <CreateCity :dialogVisible="openCreateDialog" @closeDialog="closeDialog" @getCities="getCities" />
        <UpdateCity :dialogVisible="openUpdateDialog" :city="city" @closeDialog="closeDialog" @getCities="getCities" />
        <DeleteCity :dialogVisible="openDeleteDialog" :city="city" @closeDialog="closeDialog" @getCities="getCities" />
    </SystemAuthenticatedLayout>
</template>