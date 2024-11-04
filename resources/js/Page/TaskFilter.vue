<template>
  <div class="mt-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <select @change="filterTasks" v-model="status" class="custom-select w-25">
              <option disabled selected value="">Filter by status</option>
              <option value="completed">Completed</option>
              <option value="uncompleted">Uncompleted</option>
            </select>

            <table class="table mt-3" v-if="tasks.length">
            <thead class="thead-dark">
              <tr>
                <th scope="col" width="2%">#</th>
                <th scope="col" width="7%">title</th>
                <th scope="col" width="7%">status</th>
                <th scope="col" width="1%" colspan="3">actions</th>
              </tr>
            </thead>
                <tbody>
                  <tr v-for="(task, index) in tasks" :key="task.id">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{task.title }}</td>
                    <td>
                      <span :class="task.completed ? 'badge bg-success' : 'badge bg-warning'">
                        {{ task.completed ? 'Completed' : 'Uncompleted' }}
                      </span>
                    </td>
                     <td>
                        <button @click="confirmTask(task.id)" title="Confirm">
                            <i class="bi bi-check-square" style="font-size: 1rem; color: green;"></i>
                        </button>
                      </td>
                      <td>
                        <Link :href="route('tasks.edit', task.id)" title="Edit">
                          <i class="bi bi-pencil-square" style="font-size: 1rem; color: blue;"></i>
                        </Link>
                      </td>
                      <td>
                      <button @click="deleteTask(task.id)" title="Delete">
                        <i class="bi bi-trash" style="font-size: 1rem; color: red;"></i>
                    </button>
                      </td>
                  </tr>
                </tbody>
            </table>
            <p v-else>No tasks found.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TaskFilter',
    props: {
        editUrl: String,
        confirmUrl: String,
        deleteUrl: String,
        csrfToken: String
    },
    data() {
        return {
            tasks: [],
            status: '',
            errorMessage: null
        };
    },
    // methods: {
    //     async filterTasks() {
    //         this.errorMessage = null;
    //          try {
    //             const response = await axios.get(`/tasks/filter`, { params: { status: this.status } });
    //             this.tasks = Array.isArray(response.data) ? response.data : [];
    //         } catch (error) {
    //             console.error("Failed to fetch tasks:", error);
    //             this.errorMessage = "Ошибка при загрузке задач. Пожалуйста, попробуйте снова.";
    //         }
    //     },
    //     async confirmTask(taskId) {
    //         try {
    //             await axios.put(this.confirmUrl.replace(':id', taskId), {}, {
    //                 headers: { 'X-CSRF-TOKEN': this.csrfToken }
    //             });
    //             this.filterTasks(this.selectedStatus);
    //         } catch (error) {
    //             console.error("Ошибка при подтверждении задачи:", error);
    //         }
    //     },
    //     async deleteTask(taskId) {
    //         try {
    //             await axios.delete(this.deleteUrl.replace(':id', taskId), {
    //                 headers: { 'X-CSRF-TOKEN': this.csrfToken }
    //             });
    //             this.filterTasks(this.selectedStatus);
    //         } catch (error) {
    //             console.error("Ошибка при удалении задачи:", error);
    //         }
    //     }
    // }

    methods: {
    async filterTasks() {
        this.errorMessage = null;
        try {
            const response = await axios.get(`/tasks/filter`, { params: { status: this.status } });
            this.tasks = Array.isArray(response.data) ? response.data : [];
        } catch (error) {
            console.error("Failed to fetch tasks:", error);
            this.errorMessage = "Ошибка при загрузке задач. Пожалуйста, попробуйте снова.";
        }
    },
    async confirmTask(taskId) {
        if (!this.confirmUrl) {
            console.error("confirmUrl не определен");
            return;
        }

        try {
            await axios.put(this.confirmUrl.replace(':id', taskId), {}, {
                headers: { 'X-CSRF-TOKEN': this.csrfToken }
            });
            this.filterTasks();
        } catch (error) {
            console.error("Ошибка при подтверждении задачи:", error);
        }
    },
    async deleteTask(taskId) {
        // if (!this.deleteUrl) {
        //     console.error("deleteUrl не определен");
        //     return;
        form.delete(route('posts.destroy', id));
        //}

        try {
            await axios.delete(this.deleteUrl.replace(':id', taskId), {
                headers: { 'X-CSRF-TOKEN': this.csrfToken }
            });
            this.filterTasks();
        } catch (error) {
            console.error("Ошибка при удалении задачи:", error);
        }
    },
    editTask(taskId) {
        if (!this.editUrl) {
            console.error("editUrl не определен");
            return;
        }

        const editPath = this.editUrl.replace(':id', taskId);
        window.location.href = editPath;
    }
}

};
</script>


