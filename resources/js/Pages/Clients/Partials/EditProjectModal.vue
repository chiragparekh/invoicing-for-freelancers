<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import {computed, ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {useToast} from "@/Composables/useToast.js";

const {addToast} = useToast()
const props = defineProps({
  project: {
	type: Object,
  }
})
const emits = defineEmits(['close'])
const page = usePage()
const editProjectForm = useForm({
  name: props.project.name
})
const client = computed(() => page.props.client)

const close = () => {
  emits('close')
}

const showModal = computed(() => props.project ? true :  false)

const updateProject = () => {
  editProjectForm.put(route('projects.update', {client: client.value.id, project: props.project.id}), {
	preserveScroll: true,
	onSuccess: () => {
	  close()
	  editProjectForm.reset()
	  addToast('Project details updated!')
	},
	onError: (error) => {
	  console.log("Unable to update project details", error)
	  addToast("Unable to update project details")
	},
	onFinish: () => editProjectForm.reset(),
  })
}
</script>

<template>
  <div>
	<Modal :show="showModal" @close="close">
	  <div class="p-6">
		<h2 class="text-lg font-medium text-gray-900">Edit Project</h2>
		<form @submit.prevent="updateProject">
		  <div class="mt-6">
			<div class="mt-6">
			  <InputLabel for="name" value="Name" class="sr-only" />

			  <TextInput
				  id="name"
				  ref="nameInput"
				  v-model="editProjectForm.name"
				  type="text"
				  class="mt-1 block w-full"
				  placeholder="Name"
			  />

			  <InputError :message="editProjectForm.errors.name" class="mt-2" />
			</div>

			<div class="mt-6 flex justify-end">
			  <SecondaryButton @click="close"> Cancel </SecondaryButton>

			  <PrimaryButton
				  type="submit"
				  class="ml-3"
				  :class="{ 'opacity-25': editProjectForm.processing }"
				  :disabled="editProjectForm.processing"
			  >
				Update
			  </PrimaryButton>
			</div>
		  </div>
		</form>
	  </div>
	</Modal>
  </div>
</template>