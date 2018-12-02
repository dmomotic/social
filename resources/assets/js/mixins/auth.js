let user = document.head.querySelector('meta[name="user"]');

module.exports = {
    computed:{
        currentUser(){
            return JSON.parse(user.content);
        },
        isAuthenticated(){
            return !! user.content; //Retorna un boleano
        },
        guest(){
            return ! this.isAuthenticated;
        }
    },
    methods:{
        redirectIfGuest(){ //Se asigno al div principal para que lo propague a sus hijos en StatusesList.vue
            if (this.guest) return window.location.href="/login"; 
        }
    }
};