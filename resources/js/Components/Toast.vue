<script setup>
	import { useToast } from "@/Composables/useToast.js";
	const {toasts, deleteToast} = useToast();
	import { ref } from 'vue'
	import {
	  CheckCircleIcon,
	  ExclamationTriangleIcon,
	  InformationCircleIcon,
	  XCircleIcon
	} from '@heroicons/vue/24/outline'
	import { XMarkIcon } from '@heroicons/vue/20/solid'

	const show = ref(true)

	const hideToast = (toast) => {
	  deleteToast(toast.id)
	}

	function resolveToastIcon(toast) {
	  let icon = null;
	  switch (toast.type) {
		case 'success':
		  icon = CheckCircleIcon;
		  break;
		case 'error':
		  icon = XCircleIcon;
		  break;
		case 'info':
		  icon = InformationCircleIcon;
		  break;
		case 'warning':
		  icon = ExclamationTriangleIcon;
		  break;
		default:
		  icon = InformationCircleIcon;
		  break;
	  }

	  return icon;
	}

	function resolveToastIconColor(toast) {
	  let color = '';
	  switch (toast.type) {
		case 'success':
		  color = 'text-green-400';
		  break;
		case 'error':
		  color = 'text-red-400';
		  break;
		case 'info':
		  color = 'text-blue-400';
		  break;
		case 'warning':
		  color = 'text-yellow-400';
		  break;
		default:
		  color = 'text-blue-400';
		  break;
	  }

	  return color;
	}
</script>

<template>
  <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 z-10">
	<div class="flex w-full flex-col items-center space-y-4 sm:items-end">
	  <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
	  <transition-group
		  enter-active-class="transform ease-out duration-300 transition"
		  enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
		  enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
		  leave-active-class="transition ease-in duration-100"
		  leave-from-class="opacity-100"
		  leave-to-class="opacity-0"
	  >
		<div v-for="toast in toasts" :key="toast.id"  class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
		  <div class="p-4">
			<div class="flex items-start">
			  <div class="flex-shrink-0">
				<component class="w-6 h-6"
				   :class="[resolveToastIconColor(toast)]"
				   :is="resolveToastIcon(toast)"
				/>
			  </div>
			  <div class="ml-3 w-0 flex-1 pt-0.5">
				<p class="text-sm font-medium text-gray-900">{{toast.message}}</p>
			  </div>
			  <div class="ml-4 flex flex-shrink-0">
				<button type="button" @click="hideToast(toast)" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
				  <span class="sr-only">Close</span>
				  <XMarkIcon class="h-5 w-5" aria-hidden="true" />
				</button>
			  </div>
			</div>
		  </div>
		</div>
	  </transition-group>
	</div>
  </div>
</template>