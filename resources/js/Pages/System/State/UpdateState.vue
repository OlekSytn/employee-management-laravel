<script setup>
    import { reactive, ref, toRefs, watch } from 'vue'

    const props = defineProps({
        dialogVisible: Boolean,
        state: Object
    });

    const emit = defineEmits(['getStates', 'closeDialog'])

    const { dialogVisible, state } = toRefs(props)

    const form = {
        countryId: '',
        name: '',
    }

    const formStates = reactive({...form})
    const countries = ref({})

    watch(dialogVisible, async (dialogVisible, prevVal) => {
        console.log(dialogVisible)
        if (dialogVisible) {
            countries.value = await getCountries()
        }

        formStates.countryId = state.value.country_id
        formStates.name = state.value.name
    })

    async function getCountries() {
        const result = await fetch(`/api/countries`).then(response => response.json())
        console.log(result)
        return result
    }

    async function updateState() {
        console.log('formCountry ', formStates)
        const result = 
            await fetch(`/api/states/${state.value.id}`, {
                method: 'PUT', // *GET, POST, PUT, DELETE, etc.
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    state: formStates
                })
            }).then(response => response.json())

        emit('getStates')
        emit('closeDialog', `State ${formStates.name} has been updated`)

        Object.assign(formStates, form)
        console.log('res ', result);
    }

    function selectCountry(e, a) {
        console.log(e, a)
    }
</script>

<template>
    <!-- Main modal -->
    <div v-if="dialogVisible" tabindex="-1" aria-hidden="true" class="bg-black opacity-75 grid h-screen place-items-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center"></div>
    <div v-if="dialogVisible" id="createUserModal" tabindex="-1" aria-hidden="true" class="grid h-screen place-items-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button @click="$emit('closeDialog')" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Update state</h3>
                    <div class="width-300">
                        <div>
                            <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Country</label>
                            <select 
                                v-model="formStates.countryId"
                                id="small" class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="(country, index) in countries" :selected="country.id == formStates.countryId" :key="index" :value="country.id"> {{ country.name }} </option>
                            </select>
                        </div>
                        <div class="my-0">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Country Name</label>
                            <input type="text" v-model="formStates.name" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" required="">
                        </div>
                        <button @click="updateState" class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>

<style scoped>
    .width-300 {
        width: 300px !important;
    }
</style>