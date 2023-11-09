<template>
  <div>
    <form action="" method="POST">

            <div class="modal-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" v-model="UsersData.name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email" v-model="UsersData.email" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Highest Education</label>
                    <input type="text" name="education" class="form-control" id="education" placeholder="education" v-model="UsersData.education" >
                    
                  </div>
                  <div class="form-group col-md-6 mt-4">
                    <input type="text" name="secondname" class="form-control" id="secondname" placeholder="secondname" v-model="UsersData.secondname" >
                   

                  </div>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button  type="button" class="btn btn-primary" @click="AddUsers()">Add Users</button>
            </div>
              </form>

    <div v-if="Users.length > 0">
      <h2>Registered Users</h2>
      <ul>
        <li v-for="user in Users" :key="user.id">
          {{ user.name }} - {{ user.email }} - {{ user.education }} - {{ user.secondname }}    <button @click="deleteUser(user.id)">Delete</button>
        </li>
      </ul>
    </div>
   
  </div>
</template>

<script>
import axios from 'axios';

export default {
 data() {
  return {
    UsersData: {
      name: null,
      email: null,
      education: null,
      secondname: null, // Fix: use secondname instead of gender
    },
    Users: [],
  };
},

methods: {
  AddUsers() {
    let data = new FormData();
    data.append("name", this.UsersData.name);
    data.append("email", this.UsersData.email);
    data.append("education", this.UsersData.education);
    data.append("secondname", this.UsersData.secondname); 
    console.log(data);
    axios.post('http://localhost/CRUD-VUE.JS-PHP/backend/api.php?action=addusers', data)
     .then((response) => {
          console.log(response.data);
        }).catch((err) => {
          
     console.error(err);
    });
  },

  getUsers() {
      axios.get('http://localhost/CRUD-VUE.JS-PHP/backend/api.php?action=getusers')
        .then((response) => {
          if (!response.data.error) {
            this.Users = response.data.users;
          } else {
            console.error(response.data.message);
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },

    deleteUser(userId) {
    axios.delete(`http://localhost/CRUD-VUE.JS-PHP/backend/api.php?action=deleteuser&id=${userId}`)
      .then((response) => {
        if (!response.data.error) {
          // Update the Users array after successful deletion
          this.Users = this.Users.filter(user => user.id !== userId);
        } else {
          console.error(response.data.message);
        }
      })
      .catch((err) => {
        console.error(err);
      });
  },
  },

  created() {
    this.getUsers();

},

};
</script>

<style>
/* Ajoutez vos styles CSS ici si nécessaire */
</style>
