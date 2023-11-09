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

    <li v-for="user in Users" :key="user.id">
  {{ user.firstname }} - {{ user.email }} - {{ user.education }} - {{ user.secondname }}
  <button @click="deleteUser(user.id)">Delete</button>
  <button @click="showUpdateForm(user)">Update</button>
</li>

<!-- Add the update form -->
<div v-if="showUpdateFormFlag">
  <form @submit.prevent="updateUser">
    <label for="updateName">Name</label>
    <input type="text" name="updateName" v-model="updateUserData.firstname">
     <input type="text" name="email" v-model="updateUserData.email">
      <input type="text" name="education" v-model="updateUserData.education">
       <input type="text" name="secondname" v-model="updateUserData.secondname">

    <button type="submit" >Update User</button>
  </form>
</div>
   
  </div>
</template>

<script>
import axios from 'axios';

export default {
 data() {
  return {
     showUpdateFormFlag: false,
    updateUserData: {
      id: null,
      firstname: null,
      email: null,
      education: null,
      secondname: null,
    },
    UsersData: {
      name: null,
      email: null,
      education: null,
      secondname: null, 
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
          this.Users = this.Users.filter(user => user.id !== userId);
        } else {
          console.error(response.data.message);
        }
      })
      .catch((err) => {
        console.error(err);
      });
  },

  showUpdateForm(user) {
    this.showUpdateFormFlag = true;
    this.updateUserData = { ...user };
  },

 hideUpdateForm() {
    this.showUpdateFormFlag = false;
    this.updateUserData = {
      id: null,
      name: null,
      email: null,
      education: null,
      secondname: null,
    };
  },

   updateUser() {
    let data = new FormData();
    data.append("id", this.updateUserData.id);
    data.append("name", this.updateUserData.name);
    data.append("email", this.updateUserData.email);
    data.append("education", this.updateUserData.education);
    data.append("secondname", this.updateUserData.secondname);

    axios.put('http://localhost/CRUD-VUE.JS-PHP/backend/api.php?action=updateuser', data)
      .then((response) => {
        if (!response.data.error) {
          const index = this.Users.findIndex(user => user.id === this.updateUserData.id);
          if (index !== -1) {
            this.Users.splice(index, 1, this.updateUserData);
          }
          this.hideUpdateForm();
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

</style>
