<template>
    <main-layout>
      <template #header>Permission List</template>
      <template v-if="useCheckPermission(['permission:create'])" #button>
        <Link :href="route('permissions.create')" class="py-1 px-2 rounded shadow bg-blue-500 text-white">Create</Link>
      </template>
  
      <table class="table-auto w-full p-4">
        <thead>
          <tr class="bg-gray-200 p-4">
            <th>Name</th>
            <th>Description</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="permission in permissions" :key="permission.id" class="border-b">
            <td>{{ permission.name }}</td>
            <td>{{ permission.description }}</td>
            <td class="text-right space-x-4 py-4">
              <Link v-if="useCheckPermission(['permission:update', 'permission:update-any'], permission.created_by)" :href="route('permissions.edit', permission.id)" class="py-1 px-2 rounded shadow bg-blue-500 text-white">Edit</Link>
            </td>
          </tr>
        </tbody>
      </table>
    </main-layout>
  </template>
  
  <script setup>
  import { useCheckPermission } from '@/composables/useHelpers'
  import MainLayout from '@/components/layout/MainLayout.vue'
  
  defineProps({
    permissions: Object,
  })
  </script>