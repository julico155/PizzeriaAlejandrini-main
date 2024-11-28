<script setup>
import { ref, onMounted  } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';

const themes = [
    { label: 'Light', value: 'light' },
    { label: 'Dark', value: 'dark' },
    { label: 'Children', value: 'children' },
    { label: 'Youth', value: 'youth' },
    { label: 'Adults', value: 'adults' },
];

const currentTheme = ref(localStorage.getItem('theme') || 'light');

const setTheme = (theme) => {
    currentTheme.value = theme;
    document.documentElement.setAttribute('class', `theme-${theme}`);
    localStorage.setItem('theme', theme);
};

onMounted(() => {
    setTheme(currentTheme.value); // Aplicar el tema inicial al cargar
});

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="border-b border-gray-100 bg-navigation"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex bg-navigation text-navigation transition-colors">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-navigation"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                    v-if="$page.props.auth.user.is_admin"
                                    class="text-navigation"
                                >
                                    Dashboard
                                </NavLink>
                                <NavLink
                                    :href="route('pizzas.index')"
                                    :active="route().current('pizzas.index')"
                                    class="text-navigation"
                                >
                                    Pizzas
                                </NavLink>
                                <NavLink
                                    :href="route('users.index')"
                                    :active="route().current('users.index')"
                                    v-if="$page.props.auth.user.is_admin"
                                    class="text-navigation"
                                >
                                    Users
                                </NavLink>
                                <NavLink
                                    :href="route('cajeros.index')"
                                    :active="route().current('cajeros.index')"
                                    v-if="$page.props.auth.user.is_admin"
                                    class="text-navigation"
                                >
                                    Cajeros
                                </NavLink>
                                <NavLink
                                    :href="route('clientes.index')"
                                    :active="route().current('clientes.index')"
                                    v-if="$page.props.auth.user.is_admin"
                                    class="text-navigation"
                                >
                                    Clientes
                                </NavLink>
                                <NavLink
                                    :href="route('carrito.index')"
                                    :active="route().current('carrito.index')"
                                    v-if="$page.props.auth.user.is_cliente"
                                    class="text-navigation"
                                >
                                    Carrito de compras
                                </NavLink>
                                <NavLink
                                    :href="route('historial.index')"
                                    :active="route().current('historial.index')"
                                    v-if="$page.props.auth.user.is_cliente"
                                    class="text-navigation"
                                >
                                    Historial de compras
                                </NavLink>
                            </div>
                        </div>

                        <nav>
                            <!-- Otros elementos del menú -->
                            <SearchBar />
                        </nav>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <div class="relative ms-3">
                                <label for="theme-select" class="sr-only">Select Theme</label>
                                <select
                                    id="theme-select"
                                    v-model="currentTheme"
                                    @change="setTheme(currentTheme)"
                                    class="p-2 border rounded bg-gray-200 text-gray-700"
                                >
                                    <option v-for="theme in themes" :key="theme.value" :value="theme.value">
                                        {{ theme.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Perfil
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Cerrar sesión
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            v-if="$page.props.auth.user.is_admin"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('pizzas.index')"
                            :active="route().current('pizzas.index')"
                        >
                            Pizzas
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('users.index')"
                            :active="route().current('users.index')"
                            v-if="$page.props.auth.user.is_admin"
                        >
                            Users
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('cajeros.index')"
                            :active="route().current('cajeros.index')"
                            v-if="$page.props.auth.user.is_admin"
                        >
                            Cajeros
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('clientes.index')"
                            :active="route().current('clientes.index')"
                            v-if="$page.props.auth.user.is_admin"
                        >
                            Clientes
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('carrito.index')"
                            :active="route().current('carrito.index')"
                            v-if="$page.props.auth.user.is_cliente"
                        >
                            Carrito de compras
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('historial.index')"
                            :active="route().current('historial.index')"
                            v-if="$page.props.auth.user.is_cliente"
                        >
                            Historial de pedidos
                        </ResponsiveNavLink>
                    </div>

                    
                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Perfil
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Cerrar sesión
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
<style>
/* Define styles for each theme */
html.theme-light {
    --bg-color: #ffffff;
    --text-color: #000000;
    --header-color: #f8f9fa;
}

html.theme-dark {
    --bg-color: #1f2937;
    --text-color: #ffffff;
    --header-color: #2d3748;
}

html.theme-children {
    --bg-color: #ffe4e1;
    --text-color: #ff69b4;
    --header-color: #ffb6c1;
}

html.theme-youth {
    --bg-color: #e0ffe4;
    --text-color: #006400;
    --header-color: #90ee90;
}

html.theme-adults {
    --bg-color: #fdf5e6;
    --text-color: #8b4513;
    --header-color: #deb887;
}

body {
    background-color: var(--bg-color);
    color: var(--text-color);
    transition: background-color 0.3s, color 0.3s;
}

.bg-header {
    background-color: var(--header-color);
    transition: background-color 0.3s;
}

.bg-body {
    background-color: var(--bg-color);
    transition: background-color 0.3s;
}

html.theme-light {
    --navigation-bg: #ffffff;
    --navigation-text: #000000;
}

html.theme-dark {
    --navigation-bg: #1f2937;
    --navigation-text: #ffffff;
}

html.theme-children {
    --navigation-bg: #ffe4e1;
    --navigation-text: #ff69b4;
}

html.theme-youth {
    --navigation-bg: #e0ffe4;
    --navigation-text: #006400;
}

html.theme-adults {
    --navigation-bg: #fdf5e6;
    --navigation-text: #8b4513;
}

.bg-navigation {
    background-color: var(--navigation-bg);
}

.text-navigation {
    color: var(--navigation-text);
}

.transition-colors {
    transition: background-color 0.3s, color 0.3s;
}
html.theme-light {
    --stat-card-bg: #ffffff;
    --stat-card-text: #000000;
    --chart-bg-color: rgba(153, 102, 255, 0.2);
    --chart-border-color: rgba(153, 102, 255, 1);
}

html.theme-dark {
    --stat-card-bg: #1f2937;
    --stat-card-text: #ffffff;
    --chart-bg-color: rgba(75, 192, 192, 0.2);
    --chart-border-color: rgba(75, 192, 192, 1);
}

html.theme-children {
    --stat-card-bg: #ffe4e1;
    --stat-card-text: #ff69b4;
    --chart-bg-color: rgba(255, 182, 193, 0.2);
    --chart-border-color: rgba(255, 105, 180, 1);
}

html.theme-youth {
    --stat-card-bg: #e0ffe4;
    --stat-card-text: #006400;
    --chart-bg-color: rgba(50, 205, 50, 0.2);
    --chart-border-color: rgba(34, 139, 34, 1);
}

html.theme-adults {
    --stat-card-bg: #fdf5e6;
    --stat-card-text: #8b4513;
    --chart-bg-color: rgba(210, 105, 30, 0.2);
    --chart-border-color: rgba(139, 69, 19, 1);
}

.bg-stat-card {
    background-color: var(--stat-card-bg);
}

.text-stat-card {
    color: var(--stat-card-text);
}

html.theme-light {
    --primary-text-color: #1f2937;
    --primary-bg-color: #ffffff;
    --stat-card-bg: #f3f4f6;
    --stat-card-text: #1f2937;
    --chart-bg-color: #e5e7eb;
    --chart-border-color: #1f2937;
    --card-background: #ffffff;
}

html.theme-dark {
    --primary-text-color: #f9fafb;
    --primary-bg-color: #374151;
    --stat-card-bg: #4b5563;
    --stat-card-text: #f9fafb;
    --chart-bg-color: #6b7280;
    --chart-border-color: #f9fafb;
    --card-background: #1f2937;
}

.bg-primary {
    background-color: var(--primary-bg-color);
}

.text-primary {
    color: var(--primary-text-color);
}

.bg-stat-card {
    background-color: var(--stat-card-bg);
}

.text-stat-card {
    color: var(--stat-card-text);
}

.bg-chart-background {
    background-color: var(--chart-bg-color);
}

.bg-card-background {
    background-color: var(--card-background);
}
.search-results {
    padding: 1rem;
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin-top: 1rem;
}

.search-results h3 {
    margin-bottom: 0.5rem;
}


</style>