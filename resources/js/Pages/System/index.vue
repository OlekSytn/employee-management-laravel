<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { Link } from '@inertiajs/inertia-vue3';

    const activeClasses = 'inline-block p-4 text-blue-600 rounded-t-lg border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500'
    const inactiveClasses = 'inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'
</script>

<template>
    <Head title="System Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                System Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Tabs -->
                <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-2">
                            <Link :href="route('system/country')" :class="[ route().current('system/country') ? activeClasses : inactiveClasses ]">Country</Link>
                        </li>
                        <li class="mr-2">
                            <Link :href="route('system/state')" :class="[ route().current('system/state') ? activeClasses : inactiveClasses ]">State</Link>
                        </li>
                        <li class="mr-2">
                            <Link :href="route('system/city')" :class="[ route().current('system/city') ? activeClasses : inactiveClasses ]">City</Link>
                        </li>
                        <li class="mr-2">
                            <Link :href="route('system/department')" :class="[ route().current('system/department') ? activeClasses : inactiveClasses ]">Department</Link>
                        </li>
                    </ul>
                </div>
                

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
