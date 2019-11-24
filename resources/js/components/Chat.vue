<template>
    <div class="container">
       <div class="row">
           <div class="col-8">
               <div class="card">
                   <div class="car-body p-0">
                       <ul class="list-unstyled" style="height : 300px; overflow-y : scroll">
                           <li class="list-group-item" v-for="data in message_data" :key="data.id">
                              <strong>{{ data.user.name }} - </strong> {{ data.message }}
                           </li>
                       </ul>
                   </div>
               </div>
               <div class="form-group">
                   <input type="text" @keyup.enter="sendMessage" v-model="message" placeholder="Type something" class="form form-control">
               </div>
           </div>
           <div class="col-4">
               <div class="card">
                   <div class="card-body">
                        <strong class="car-header text-muted mb-2">Active User</strong>
                        <ul>
                           <li class="text-success" v-for="user in users" :key="user.id">
                               {{ user.name }}
                           </li>
                        </ul>
                   </div>
               </div>
           </div>
       </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        props : [ 'user' ],
        data : function(){
            return {
                message : '',
                message_data : [],
                users : []
            }
        },
        methods : {
            sendMessage : function(){
                let vm= this;
                axios.post('/chat_store',{
                    'message' : this.message
                })
                .then(response => {
                    vm.message='';
                    this.fetchData();
                })
                .catch(error => {
                    console.log(error.response);
                })
            },
            fetchData : function(){
                let vm= this;
                axios.get('/chat_data')
                .then(response => {
                    vm.message_data= [];
                    vm.message_data= response.data;
                })
                .catch(error => {
                    console.log(error.response);
                })
            }
        },
        created() {
            this.fetchData();
            Echo.join('chat')
            .here(user =>{
                console.log("here");
                this.users = user;
            })
            .joining(user => {
                console.log("joining");
                this.users.push(user);
            })
            .leaving(user => {
                console.log("leaving");
                this.users= this.users.filter(u => u.id != user.id)
            })
            .listen('ChatEvent', (event) => {
                this.message_data.push(event.message);
            })
        }
    }
</script>
