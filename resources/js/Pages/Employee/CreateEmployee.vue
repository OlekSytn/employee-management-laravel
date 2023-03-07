<script setup>
    import { reactive, ref, toRefs, watch, unref, toRaw } from 'vue'

    const props = defineProps({
        dialogVisible: Boolean
    });

    const emit = defineEmits(['getEmployees', 'closeDialog'])

    const { dialogVisible } = toRefs(props)
    const departments = ref([])
    const countries = ref([])
    const states = ref([])
    const cities = ref([])

    const form = {
        lastName: '',
        firstName: '',
        middleName: '',
        address: '',
        departmentId: '',
        countryId: '',
        stateId: '',
        cityId: '',
        zipcode: '',
    }

    const formEmployee = reactive({...form})

    watch(dialogVisible, async (dialogVisible, prevVal) => {
        console.log(dialogVisible)
        if (dialogVisible) {
            departments.value = await getDepartments()
            countries.value = await getCountries()
        }
    })

    async function selectCountry() {
        console.log(formEmployee.countryId)
        states.value = await getStates(formEmployee.countryId)
    }

    async function selectState() {
        console.log(formEmployee.stateId)
        cities.value = await getCities(formEmployee.stateId)
    }

    async function createEmployee() {
        console.log('formEmployee ', formEmployee)
        const result = await axios.post(`/api/employees`, formEmployee)

        emit('getEmployees')
        emit('closeDialog', `Employee ${formEmployee.lastName}, ${formEmployee.firstName} ${formEmployee.middleName} has been created`)

        Object.assign(formEmployee, form)
        console.log('res ', result);
    }

    async function getDepartments() {
        return await fetch(`/api/departments`).then(response => response.json())
    }

    async function getCountries() {
        return await fetch(`/api/countries`).then(response => response.json())
    }

    async function getStates(countryId) {
        return await fetch(`/api/states/${countryId}`).then(response => response.json())
    }

    async function getCities(stateId) {
        return await fetch(`/api/cities/${stateId}`).then(response => response.json())
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
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Create employee</h3>
                    <div class="width-300">
                        <div>
                            <label for="firstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">First Name</label>
                            <input type="text" v-model="formEmployee.firstName" name="firstName" id="firstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" required="">
                        </div>
                        <div class="my-0">
                            <label for="lastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Last Name</label>
                            <input type="text" v-model="formEmployee.lastName" name="lastName" id="lastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" required="">
                        </div>
                        <div>
                            <label for="middleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Middle Name</label>
                            <input type="text" v-model="formEmployee.middleName" name="middleName" id="middleName" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Address</label>
                            <input type="text" v-model="formEmployee.address" name="address" id="address" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <div>
                            <label for="departmentId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Department</label>
                            <select 
                                v-model="formEmployee.departmentId"
                                id="small" class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="(department, index) in departments" :selected="department.id == formEmployee.departmentId" :key="index" :value="department.id"> {{ department.name }} </option>
                            </select>
                        </div>
                        <div>
                            <label for="countryId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Country</label>
                            <select 
                                v-model="formEmployee.countryId"
                                @change="selectCountry"
                                id="small" class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="(country, index) in countries" :selected="country.id == formEmployee.countryId" :key="index" :value="country.id"> {{ country.name }} </option>
                            </select>
                        </div>
                        <div>
                            <label for="stateId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">State</label>
                            <select 
                                v-model="formEmployee.stateId"
                                @change="selectState"
                                id="small" class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="(state, index) in states" :selected="state.id == formEmployee.stateId" :key="index" :value="state.id"> {{ state.name }} </option>
                            </select>
                        </div>
                        <div>
                            <label for="cityId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">City</label>
                            <select 
                                v-model="formEmployee.cityId"
                                id="small" class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="(city, index) in cities" :selected="city.id == formEmployee.cityId" :key="index" :value="city.id"> {{ city.name }} </option>
                            </select>
                        </div>
                        <div>
                            <label for="zipcode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Zipcode</label>
                            <input type="text" v-model="formEmployee.zipcode" name="zipcode" id="zipcode" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <button @click="createEmployee" class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
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