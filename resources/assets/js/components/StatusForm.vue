<template>
    <div>
        <form @submit.prevent="submit" v-if="isAuthenticated">
            <div class="card-body">
                <textarea v-model="body" 
                    class="form-control border-0 bg-light" 
                    name="body" 
                    :placeholder="`Que estas pensando ${currentUser.name}?`">

                </textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="create-status">
                    <i class="fa fa-paper-plane mr-1"></i>
                    Publicar
                </button>
            </div>
        </form>
        <div v-else class="card-body">
            <a href="/login">Debes iniciar sesion</a>
        </div>
    </div>
</template>

<script>
    //import auth from '../mixins/auth';  //Solo si no lo registramos de forma global
    
    export default {
        data(){
            return{
                body:''
            }
        },
        //mixins: [auth], //Solo si no lo registramos de forma global
        methods:{
            submit(){
                axios.post('/statuses', {body: this.body})
                    .then(res => {
                        EventBus.$emit('status-created', res.data.data) // ['data' => ['body' => 'contenido']]
                        this.body = ''
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
