<script setup>
    import { reactive, ref, toRefs, watch, unref, toRaw } from 'vue'

    const props = defineProps({
        dialogVisible: Boolean
    });

    const emit = defineEmits(['getUsers', 'closeDialog'])

    const { dialogVisible } = toRefs(props)

    const form = {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        username: ''
    }

    const formUser = reactive({...form})

    async function createUser() {
        console.log('formUser ', formUser)
        const result = await axios.post(`/api/users`, formUser)

        emit('getUsers')
        emit('closeDialog', `User ${formUser.username} has been created`)

        Object.assign(formUser, form)
        console.log('res ', result);
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
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Create account</h3>
                    <div class="width-300">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
                            <input type="text" v-model="formUser.username" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" required="">
                        </div>
                        <div class="my-0">
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Firstname</label>
                            <input type="text" v-model="formUser.first_name" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" required="">
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Lastname</label>
                            <input type="text" v-model="formUser.last_name" name="last_name" id="last_name" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                            <input type="email" v-model="formUser.email" name="email" id="email" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                            <input type="password" v-model="formUser.password" name="password" id="password" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Confirm Password</label>
                            <input type="password" v-model="formUser.password_confirmation" name="password_confirmation" id="password_confirmation" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
                        </div>
                        <button @click="createUser" class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
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