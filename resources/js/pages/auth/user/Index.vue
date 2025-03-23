<template>
  <main-layout>
    <template #header>User List</template>
    <template v-if="useCheckPermission(['user:create'])" #button>
      <Link :href="route('users.create')" class="py-1 px-2 rounded shadow bg-blue-500 text-white">Create</Link>
    </template>

    <table class="table-auto w-full p-4">
      <thead>
        <tr class="bg-gray-200 p-4">
          <th>Name</th>
          <th>Email</th>
          <th class="text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" class="border-b">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td class="text-right space-x-4 py-4">
            <template v-if="user.id != 1">
              <Link v-if="useCheckPermission(['user:update', 'user:update-any'], user.created_by)" :href="route('users.edit', user.id)" class="py-1 px-2 rounded shadow bg-blue-500 text-white">Edit</Link>
              <Link v-if="useCheckPermission(['user:delete', 'user:delete-any'], user.created_by)" method="DELETE" :href="route('users.destroy', user.id)" class="py-1 px-2 rounded shadow bg-red-500 text-white">Delete</Link>
            </template>
          </td>
        </tr>
      </tbody>
    </table>
  </main-layout>
</template>

<script setup>
import { useCheckPermission } from '@/composables/useHelpers'

import MainLayout from '@/components/layout/MainLayout.vue'

const props = defineProps({
  users: Object,
})
</script>