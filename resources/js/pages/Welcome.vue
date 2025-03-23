<template>
  <div class="container mx-auto h-screen flex items-center justify-center">
    <form @submit.prevent="submit" class="rounded p-4 shadow-lg bg-white space-y-6 w-96">
      <p class="text-center mt-4 w-full font-bold text-3xl text-gray-700">Permission app</p>

      <div>
        <label for="email" class="text-gray-500 font-bold text-sm pl-2">Email</label>
        <input type="text" placeholder="johndoe@email.com" v-model="form.email"
          class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800">
      </div>

      <div>
        <label for="password" class="text-gray-500 font-bold text-sm pl-2">Password</label>
        <input type="password" placeholder="*******" v-model="form.password"
          class="w-full p-2 border border-gray-300 rounded mt-2 text-gray-800">
      </div>

      <button class="w-full bg-blue-500 text-white font-bold py-2 rounded">
        Login
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

const submit = () => {
  form.post(route('login.store'))
}
</script>
