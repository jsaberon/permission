<template>
  <div class="min-h-full">
    <nav class="bg-gray-800">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="hidden md:block">
              <nav-links />
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6 space-x-4">
              <p class="text-white font-bold text-yellow-500">{{ $page?.props?.auth?.user?.name ?? ''}}</p>
              <Link href="/logout" method="DELETE" as="form" class="text-white">Logout</Link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          <slot name="header" />
        </h1>
        <slot name="button" />
      </div>
    </header>

    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import NavLinks from './NavLinks.vue';
</script>