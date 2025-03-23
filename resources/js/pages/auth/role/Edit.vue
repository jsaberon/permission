<template>
    <main-layout>
      <template #header>Role Edit</template>
  
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="email" class="text-gray-500 font-bold text-sm pl-2">name</label>
          <input type="text" placeholder="john doe" v-model="form.name"
            class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800">
          <div v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</div>
        </div>
  
        <div class="w-full">
          <label for="" class="pl-1 block text-sm text-gray-500">Permissions</label>
          <v-select multiple label="permission" v-model="form.permissions" :options="option_permissions" />
          <div v-if="form.errors.permissions" class="text-xs text-red-500">{{ form.errors.permissions }}</div>
        </div>
  
        <div class="w-full flex justify-between space-x-4">
          <Link :href="route('roles.index')" class="w-full">
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
  import { computed } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  
  import MainLayout from '@/components/layout/MainLayout.vue'
  
  const props = defineProps({
    role: Object,
    permissions: Object,
  })
  
  const option_permissions = computed(() => props.permissions.filter(permission => !form.permissions.includes(permission)))

  const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions.map(permission => permission.name),
  })
  
  const submit = () => {
    form.patch(route('roles.update', props.role.id))
  }
  </script>