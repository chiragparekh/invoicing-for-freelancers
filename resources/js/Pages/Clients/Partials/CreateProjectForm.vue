<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
const client = usePage().props.client;

const form = useForm({
  name: '',
});

const createProject = async  () => {
  await form.post(route('projects.store', {client: client.id}), {
	preserveScroll: true
  })

  form.name = ''
}
</script>

<template>
  <section>
	<form class="mt-6 flex space-y-6 gap-x-4 items-start w-full" @submit.prevent="createProject">
	  <div class="w-full">
		<InputLabel for="name" value="Name" />

		<TextInput
			id="name"
			type="text"
			class="mt-1 block w-full"
			v-model="form.name"
			autofocus
			autocomplete="name"
		/>

		<InputError class="mt-2" :message="form.errors.name" />

		<Transition
			enter-active-class="transition ease-in-out"
			enter-from-class="opacity-0"
			leave-active-class="transition ease-in-out"
			leave-to-class="opacity-0"
		>
		  <p v-if="form.recentlySuccessful" class="mt-2 text-sm text-gray-600">Project Created.</p>
		</Transition>
	  </div>

	  <div class="items-center gap-4">
		<PrimaryButton :disabled="form.processing">Save</PrimaryButton>
	  </div>
	</form>
  </section>
</template>
