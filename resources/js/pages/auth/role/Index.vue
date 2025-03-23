<template>
  <main-layout>
    <template #header>Role List</template>
    <template v-if="useCheckPermission(['role:create'])" #button>
      <Link :href="route('roles.create')" class="py-1 px-2 rounded shadow bg-blue-500 text-white">Create</Link>
    </template>

    <table class="table-auto w-full p-4">
      <thead>
        <tr class="bg-gray-200 p-4">
          <th>Name</th>
          <th class="text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="role in roles" :key="role.id" class="border-b">
          <td>{{ role.name }}</td>
          <td class="text-right space-x-4 py-4">
            <Link v-if="useCheckPermission(['role:update', 'role:update-any'], role.created_by)" :href="route('roles.edit', role.id)" class="py-1 px-2 rounded shadow bg-blue-500 text-white">Edit</Link>
            <Link v-if="useCheckPermission(['role:delete', 'role:delete-any'], role.created_by)" method="DELETE" :href="route('roles.destroy', role.id)" class="py-1 px-2 rounded shadow bg-red-500 text-white">Delete</Link>
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
  roles: Object,
})
</script>