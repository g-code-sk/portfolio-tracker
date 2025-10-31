<template>
    <aside class="fixed top-[72px] left-0 z-40 h-[calc(100vh-72px)] w-64 overflow-y-auto border-r border-gray-200 bg-gray-50">
        <nav class="p-4">
            <div class="mb-6">
                <h2 class="mb-2 px-3 text-xs font-semibold tracking-wider text-gray-500 uppercase">Main Menu</h2>
                <ul class="space-y-1">
                    <li>
                        <router-link
                            to="/app/dashboard"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                />
                            </svg>
                            Dashboard
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            to="/app/portfolios"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                />
                            </svg>
                            Portfolios
                        </router-link>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            Transactions
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-6">
                <h2 class="mb-2 px-3 text-xs font-semibold tracking-wider text-gray-500 uppercase">Tools</h2>
                <ul class="space-y-1">
                    <li>
                        <a
                            href="#"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            Reports
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
</template>

<script setup lang="ts"></script>
