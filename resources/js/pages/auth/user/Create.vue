<template>
  <main-layout>
    <template #header>User Create</template>

    <form @submit.prevent="submit" class="space-y-6">
      <div>
        <label for="email" class="text-gray-500 font-bold text-sm pl-2">name</label>
        <input type="text" placeholder="john doe" v-model="form.name"
          class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800">
        <div v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</div>
      </div>

      <div>
        <label for="email" class="text-gray-500 font-bold text-sm pl-2">Email</label>
        <input type="text" placeholder="johndoe@email.com" v-model="form.email"
          class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800">
        <div v-if="form.errors.email" class="text-xs text-red-500">{{ form.errors.email }}</div>
      </div>

      <div class="w-full">
        <label for="" class="pl-1 block text-sm text-gray-500">Roles</label>
        <v-select multiple label="role" v-model="form.roles" :options="option_roles" />
      </div>

      <div class="w-full flex justify-between space-x-4">
        <Link :href="route('users.index')" class="w-full">
          <button class="w-full bg-slate-300 text-gray-800 font-bold py-2 rounded">
            Back
          </button>
        </Link>
        
        <button class="w-full bg-blue-500 text-white font-bold py-2 rounded">
          Create
        </button>
      </div>
    </form>
  </main-layout>
</template>

<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

import MainLayout from '@/components/layout/MainLayout.vue'

const props = defineProps({
  roles: Object,
})

const option_roles = computed(() => props.roles.filter(role => !form.roles.includes(role)))

const form = useForm({
  name: '',
  email: '',
  roles: [],
})

const submit = () => {
  form.post(route('users.store'))
}
</script>