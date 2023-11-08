<template>
  <div>
    <h2>Formulaire d'Enregistrement d'Étudiant</h2>
    <form @submit.prevent="saveStudent">
      <div class="form-group">
        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" v-model="student.firstName" required>
      </div>
      <div class="form-group">
        <label for="last_name">Nom de Famille :</label>
        <input type="text" id="last_name" v-model="student.lastName" required>
      </div>
      <div class="form-group">
        <label for="email">Adresse E-mail :</label>
        <input type="email" id="email" v-model="student.email" required>
      </div>
      <button type="submit">Enregistrer</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'; 

export default {
  data() {
    return {
      student: {
        firstName: '',
        lastName: '',
        email: '',
      },
    };
  },
  methods: {
    saveStudent() {
      
      axios.post('http://localhost:8081/server/api.php', this.student)
        .then(response => {
          
          console.log(response.data);
          
          this.clearForm();
        })
        .catch(error => {
          console.error('Error:', error);
        });
    },
    clearForm() {
      this.student.firstName = '';
      this.student.lastName = '';
      this.student.email = '';
    },
  },
};
</script>

<style scoped>
.form-group {
  margin-bottom: 15px;
}
</style>
