<template>
  <div>
    <h1>Task List</h1>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Is Done</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.title }}</td>
          <td>{{ task.description }}</td>
          <td>
            <input type="checkbox" v-model="task.is_done" @change="updateTask(task)" />
          </td>
          <td>{{ task.created_at }}</td>
          <td>{{ task.updated_at }}</td>
          <td>
            <button @click="deleteTask(task.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <h2>Add New Task</h2>
    <form @submit.prevent="addTask">
      <label>
        Title:
        <input type="text" v-model="newTask.title" required />
      </label>
      <label>
        Description:
        <textarea v-model="newTask.description" required></textarea>
      </label>
      <button type="submit">Add Task</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "TaskList",
  data() {
    return {
      tasks: [],
      newTask: {
        title: "",
        description: "",
        is_done: false,
      },
    };
  },
  mounted() {
    this.getTasks();
  },
  methods: {
    getTasks() {
      axios
        .get("http://localhost:8000/tasks")
        .then((response) => {
          this.tasks = response.data;
        })
        .catch((error) => {
          console.error("Error fetching tasks:", error);
        });
    },
    addTask() {
      axios
        .post("http://localhost:8000/tasks", this.newTask)
        .then((response) => {
          this.tasks.push(response.data);
          this.newTask = { title: "", description: "", is_done: false };
        })
        .catch((error) => {
          console.error("Error adding task:", error);
        });
    },
    updateTask(task) {
      axios.put(`http://localhost:8000/tasks/${task.id}`, task).catch((error) => {
        console.error("Error updating task:", error);
      });
    },
    deleteTask(id) {
      axios
        .delete(`http://localhost:8000/tasks/${id}`)
        .then(() => {
          this.tasks = this.tasks.filter((task) => task.id !== id);
        })
        .catch((error) => {
          console.error("Error deleting task:", error);
        });
    },
  },
};
</script>
