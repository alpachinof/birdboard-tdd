<x-modal name="confirm-user-deletion" max-width="2xl" :show="true" focusable>
    <div x-data="newProject()" class="p-10 rounded-lg dark:text-white">
        <h1 class="font-normal mb-16 text-center text-2xl">Let's start something new</h1>

        <div class="flex">
            <div class="flex-1 mr-4">
                <div class="mb-4">
                    <label for="title" class="text-sm block mb-2">Title</label>

                    <input type="text" id="title"
                        class="border border-muted-light p-2 text-xs block w-full rounded dark:text-gray-800">
                </div>

                <div class="mb-4">
                    <label for="description" class="text-sm block mb-2">Description</label>

                    <textarea type="text" id="description" rows="7"
                        class="border border-muted-light p-2 text-xs block w-full rounded dark:text-gray-800"></textarea>
                </div>
            </div>

            <div class="flex-1 ml-4">
                <div class="mb-4">
                    <label class="text-sm block mb-2">Need Some Tasks?</label>
                    <template x-for="task in tasks">
                        <input type="text" x-model="task.value"
                            class="border border-muted-light mb-2 p-2 text-xs block w-full rounded dark:text-gray-800">
                    </template>
                </div>

                <button @click.prevent="addTask" class="inline-flex items-center text-xs">

                    <span>Add new task field</span>
                </button>
            </div>
        </div>

        <footer class="flex justify-end">
            <x-secondary-button class="mr-4" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <button class="button">Create Project</button>
        </footer>
    </div>
</x-modal>

<script>
    function newProject() {
        return {
            tasks: [{
                value: 'fdfd'
            }],
            addTask() {
                this.tasks.push({
                    value: ''
                })
            }
        }
    }
</script>
