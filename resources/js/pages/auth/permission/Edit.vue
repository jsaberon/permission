<template>
  <main-layout>
    <template #header>Permission Create</template>

    <div class="p-4 bg-blue-200 rounded shadow text-xs text-gray-600">
      <p>You cannot update the name of the permission. you can only update the description</p>
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      <div>
        <label for="email" class="text-gray-500 font-bold text-sm pl-2">Name</label>
        <input type="text" placeholder="permission:create" v-model="form.name"
          class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800" readonly>
      </div>

      <div>
        <label for="email" class="text-gray-500 font-bold text-sm pl-2">Description</label>
        <input type="text" placeholder="Create permission" v-model="form.description"
          class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800">
        <div v-if="form.errors.description" class="text-xs text-red-500">{{ form.errors.description }}</div>
      </div>

      <div class="w-full flex justify-between space-x-4">
        <Link :href="route('permissions.index')" class="w-full">
        <button class="w-full bg-slate-300 text-gray-800 font-bold py-2 rounded">
          Back
        </button>
        </Link>

        <button class="w-full bg-blue-500 text-white font-bold py-2 rounded">
          Update
        </button>
      </div>
    </form>
  </main-layout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

import MainLayout from '@/components/layout/MainLayout.vue'

const props = defineProps({
  permission: Object,
})

const form = useForm({
  name: props.permission.name,
  description: props.permission.description,
})

const submit = () => {
  form.patch(route('permissions.update', props.permission.id))
}
</script>