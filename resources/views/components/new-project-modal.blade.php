<x-modal name="new-project-modal" max-width="2xl" focusable>
    <div x-data="newProject()" class="p-10 rounded-lg dark:text-white">
        <h1 class="font-normal mb-16 text-center text-2xl">Let's start something new</h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <x-input-label value="Title" for="title" class="mb-2" />
                        <x-text-input id="title" x-model="form.title" class="block w-full" ::class="errors.title ? 'border-red-400 dark:border-red-400' : ''" />
                        <span class="text-xs italic text-red-400" x-show="errors.title" x-text="errors.title[0]"></span>
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Description" for="description" class="mb-2" />
                        <textarea type="text" id="description" rows="7" x-model="form.description"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 
                            dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            :class="errors.description ? 'border-red-400 dark:border-red-400' : ''"></textarea>
                        <span class="text-xs italic text-red-400" x-show="errors.description"
                            x-text="errors.description[0]"></span>

                    </div>
                </div>

                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="text-sm block mb-2">Need Some Tasks?</label>
                        <template x-for="task in form.tasks">
                            {{-- <input type="text" x-model="task.body"
                                class="border border-muted-light mb-2 p-2 text-xs block w-full rounded dark:text-gray-800"> --}}
                            <x-text-input x-model="task.body" class="block w-full mb-2" />

                        </template>
                    </div>

                    <button type="button" @click.prevent="addTask" class="inline-flex items-center text-xs">

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
        </form>
    </div>
</x-modal>

<script>
    function newProject() {
        return {
            form: {
                title: '',
                description: '',
                tasks: [{
                    body: ''
                }],
            },
            errors: [],
            addTask() {
                this.form.tasks.push({
                    body: ''
                })
            },
            submit() {
                axios.post('/projects', this.form)
                    .then(response => {
                        location = response.data.message;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>
