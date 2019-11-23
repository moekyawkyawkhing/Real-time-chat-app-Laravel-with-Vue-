<template>
    <div class="container">
       <div class="row">
           <div class="col-8">
               <div class="card">
                   <div class="car-body p-0">
                       <ul class="list-unstyled" style="height : 300px; overflow-y : scroll">
                           <li class="list-group-item" v-for="data in message_data" :key="data.id">
                              <strong>{{ user.name }} - </strong> {{ data.message }}
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
                        <ul class="list-unstyled">
                           <li class="list-group-item">
                               John
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
                message_data : []
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
                    console.log(response.data);
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
                console.log(user)
            })
            .joining(user => {
                console.log(user)
            })
            .listen('ChatEvent', (event) => {
                console.log("listen event");
                this.message_data.push(event.message);
            })
        }
    }
</script>
